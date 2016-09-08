<?php

namespace Despark\Cms\Observers;

use Despark\Cms\Contracts\ImageContract;
use Despark\Cms\Models\Image;

/**
 * Class ImageModelObserver.
 */
class ImageModelObserver
{
    /**
     * @param Image $model
     */
    public function deleted(ImageContract $model)
    {
        $imageTypes = $model->getAllImages();

        foreach ($imageTypes as $images) {
            foreach ($images as $path) {
                \File::delete($path);
            }
        }
    }
}
