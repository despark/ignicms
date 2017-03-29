<?php

namespace Despark\Cms\Video\Providers;

use Despark\Cms\Models\Video;
use Despark\Cms\Video\Provider;

/**
 * Class YouTube.
 */
class Vimeo extends Provider
{
    public function __construct(Video $model)
    {
        parent::__construct($model);

        try {
            $videoInfo = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$this->model->video_id}.php"));
            $this->imageUrl = $videoInfo[0]['thumbnail_large'];
            $this->videoUrl = 'https://player.vimeo.com/video/'.$this->model->video_id;
        } catch (Exception $e) {
            \Log::debug($e);
        }
    }
}
