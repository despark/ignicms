<?php

namespace Despark\Cms\Observers;

use Carbon\Carbon;
use Despark\Cms\Models\AdminModel;
use Despark\Cms\Models\Video;
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

            foreach ($data as $fieldName => $items) {
                foreach ($items as $item) {
                    $insert[] = [
                        'resource_id' => $model->getKey(),
                        'resource_model' => $resourceModel,
                        'field' => $fieldName,
                        'provider' => 'youtube',
                        'video_id' => $item['video_id'],
                        'config' => null,
                        'order' => $item['order'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            if (! empty($insert)) {
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
                        $video->video_id = $this->processVideoIdValue($item['video_id']);
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
     * @return array
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
                        $value = $this->processVideoIdValue($value);
                    }

                    $data[$fieldName][$i][$attribute] = $value;
                }
            }
        }

        return $data;
    }

    /**
     * Processes Video id and gets it from provider url.
     * @param $videoId
     * @return mixed
     * @throws \Exception
     */
    protected function processVideoIdValue($videoId)
    {
        if (filter_var($videoId, FILTER_VALIDATE_URL) !== false) {
            $urlParsed = parse_url($videoId);
            parse_str($urlParsed['query'], $urlParts);
            if (! isset($urlParts['v'])) {
                throw new \Exception('We support only YouTube for now urls.');
            }
            $videoId = $urlParts['v'];
        }

        return $videoId;
    }
}
