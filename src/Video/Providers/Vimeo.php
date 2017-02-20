<?php

namespace Despark\Cms\Video\Providers;

use Despark\Cms\Video\Provider;

/**
 * Class YouTube.
 */
class Vimeo extends Provider
{
    protected $videoUrl = 'https://player.vimeo.com/video';

    public function toHtml($preview = false)
    {
        if ($preview) {
            $videoInfo = unserialize(file_get_contents('http://vimeo.com/api/v2/video/203689226.php'));
            $imageUrl = $videoInfo[0]['thumbnail_large'];

            return "<img src='{$imageUrl}' />";
        }

        return "<iframe src='{$this->videoUrl}/{$this->model->video_id}' frameborder='0' allowfullscreen></iframe>";
    }
}
