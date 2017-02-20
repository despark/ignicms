<?php

namespace Despark\Cms\Video;

use Despark\Cms\Models\Video;
use Despark\Cms\Video\Contracts\VideoProviderContract;

/**
 * Class Provider.
 */
abstract class Provider implements VideoProviderContract
{
    /**
     * @var Video
     */
    protected $model;

    protected $imageUrl;
    protected $videoUrl;

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    /**
     * @param bool $preview
     *
     * @return mixed
     */
    public function toHtml($preview = false)
    {
        if ($preview) {
            return "<img src='{this->imageUrl}/{$this->model->video_id}' />";
        }

        return "<iframe src='{$this->videoUrl}/{$this->model->video_id}' frameborder='0' allowfullscreen></iframe>";
    }

    public function getModel()
    {
        return $this->model;
    }
}
