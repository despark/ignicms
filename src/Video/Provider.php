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

    /**
     * @var string
     */
    protected $imageUrl;

    /**
     * @var string
     */
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
    public function toHtml(bool $preview = false)
    {
        if ($preview) {
            return "<img src='{$this->imageUrl}' style='max-width: 100%;' />";
        }

        return "<iframe src='{$this->videoUrl}' frameborder='0' allowfullscreen></iframe>";
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * Gets the value of imageUrl.
     *
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Gets the value of videoUrl.
     *
     * @return mixed
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }
}
