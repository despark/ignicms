<?php

namespace Despark\Cms\Observers;

use Carbon\Carbon;
use Despark\Cms\Models\Video;
use Despark\Cms\Models\AdminModel;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AdminModelObserver.
 */
class AdminModelObserver
{
    /**
     * @param AdminModel $model
     */
    public function saved(AdminModel $model)
    {
        if ($model->allowsVideo()) {
            $files = $model->getFiles();
            // we need to check for files uploaded
            $newVideos = array_get($files, 'new.video', []);
            $existingVideos = array_get($files, 'video', []);

            $data = $this->normalizeVideosArray($newVideos);

            $insert = [];
            $resourceModel = $model->getMorphClass();

            $videoInfo = $this->processVideoIdValue($item['video_id']);

            foreach ($data as $fieldName => $items) {
                foreach ($items as $item) {
                    $insert[] = [
                        'resource_id' => $model->getKey(),
                        'resource_model' => $resourceModel,
                        'field' => $fieldName,
                        'provider' => array_get($videoInfo, 'provider'),
                        'video_id' => array_get($videoInfo, 'id'),
                        'meta' => null,
                        'order' => $item['order'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            if (!empty($insert)) {
                // Save relations
                $table = explode('.', $model->videos()->getMorphType())[0];
                \DB::table($table)->insert($insert);
            }

            // Now process deleted and edited videos
            $videoIds = [];
            foreach ($existingVideos as $fieldName => $items) {
                $videoIds = array_merge($videoIds, array_keys($items));
            }

            if ($videoIds) {
                /** @var Collection $collection */
                $collection = $model->videos()->whereIn('id', $videoIds)->get()->keyBy('id');
                foreach ($existingVideos as $fieldName => $items) {
                    foreach ($items as $item) {
                        $video = $collection->get($item['id']);
                        if (isset($item['delete']) && $item['delete']) {
                            $video->delete();
                            continue;
                        }

                        $videoInfo = $this->processVideoIdValue($item['video_id']);
                        $video->video_id = array_get($videoInfo, 'id');
                        $video->provider = array_get($videoInfo, 'provider');
                        $video->order = $item['order'];
                        $video->save();
                    }
                }
            }
        }
    }

    /**
     * @param AdminModel $model
     */
    public function deleted(AdminModel $model)
    {
        if ($model->allowsVideo()) {
            $model->videos()->delete();
        }
    }

    /**
     * @param array $array
     * @param array $deleted
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function normalizeVideosArray(array $array, array &$deleted = [])
    {
        $data = [];
        foreach ($array as $fieldName => $videoData) {
            $deleted[$fieldName] = [];
            foreach ($videoData as $attribute => $items) {
                foreach ($items as $i => $value) {
                    if (in_array($i, $deleted)) {
                        continue;
                    }

                    if ($attribute == 'delete' && $value == 1) {
                        if (isset($data[$fieldName][$i])) {
                            unset($data[$fieldName][$i]);
                            $deleted[$fieldName] = $i;
                            continue;
                        }
                    }

                    if ($attribute == 'video_id') {
                        $videoInfo = $this->processVideoIdValue($value);
                        if ($videoInfo) {
                            $value = array_get($videoInfo, 'id');
                            $data[$fieldName][$i]['provider'] = array_get($videoInfo, 'provider');
                        }
                    }

                    $data[$fieldName][$i][$attribute] = $value;
                }
            }
        }

        return $data;
    }

    /**
     * Processes Video id and gets it from provider url.
     *
     * @param $videoString
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function processVideoIdValue($videoString)
    {
        $video = stripslashes(trim($videoString));
        // check for iframe to get the video url
        if (strpos($video, 'iframe') !== false) {
            // retrieve the video url
            $anchorRegex = '/src="(.*)?"/isU';
            $results = array();
            if (preg_match($anchorRegex, $video, $results)) {
                $link = trim($results[1]);
            }
        } else {
            // we already have a url
            $link = $video;
        }

        // if we have a URL, parse it down
        if (!empty($link)) {
            // initial values
            $id = null;
            $videoIdRegex = null;
            $results = [];
            if (strpos($link, 'youtu') !== false) {
                if (strpos($link, 'youtube.com') !== false) {
                    // works on:
                    // http://www.youtube.com/embed/VIDEOID
                    // http://www.youtube.com/embed/VIDEOID?modestbranding=1&amp;rel=0
                    // http://www.youtube.com/v/VIDEO-ID?fs=1&amp;hl=en_US
                    $videoIdRegex = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/";
                } elseif (strpos($link, 'youtu.be') !== false) {
                    // works on:
                    // http://youtu.be/daro6K6mym8
                    $videoIdRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
                }

                if ($videoIdRegex !== null) {
                    if (preg_match($videoIdRegex, $link, $results)) {
                        $id = $results[1];
                        $provider = 'youtube';
                    }
                }
            } elseif (strpos($video, 'vimeo') !== false) {
                if (strpos($video, 'player.vimeo.com') !== false) {
                    // works on:
                    // http://player.vimeo.com/video/37985580?title=0&amp;byline=0&amp;portrait=0
                    $videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
                } else {
                    // works on:
                    // http://vimeo.com/37985580
                    $videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
                }

                if ($videoIdRegex !== null) {
                    if (preg_match($videoIdRegex, $link, $results)) {
                        $id = $results[1];
                        $provider = 'vimeo';
                    }
                }
            }

            if (!empty($id)) {
                return compact('id', 'provider');
            }
        }
    }
}
