<?php

namespace Despark\Cms\Video\Providers;

use Despark\Cms\Video\Provider;

/**
 * Class YouTube.
 */
class YouTube extends Provider
{
    public function toHtml($preview = false)
    {
        if ($preview) {
            return "<img src=\"http://img.youtube.com/vi/{$this->model->video_id}\" />";
        } else {
            return "<iframe src=\"https://www.youtube.com/embed/{$this->model->video_id}\" />";
        }
    }
}
