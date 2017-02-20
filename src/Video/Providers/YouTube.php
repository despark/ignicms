<?php

namespace Despark\Cms\Video\Providers;

use Despark\Cms\Models\Video;
use Despark\Cms\Video\Provider;

/**
 * Class YouTube.
 */
class YouTube extends Provider
{
    protected $imageUrl = 'http://img.youtube.com/vi';
    protected $videoUrl = 'https://www.youtube.com/embed';

    public function __construct(Video $model)
    {
        parent::__construct($model);

        $this->imageUrl = "http://img.youtube.com/vi/{$this->model->video_id}/0.jpg";
        $this->videoUrl = 'https://www.youtube.com/embed/'.$this->model->video_id;
    }
}
