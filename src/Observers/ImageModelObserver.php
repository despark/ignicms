<?php

namespace Despark\Cms\Observers;

use Despark\Cms\Models\Image;

/**
 * Class ImageModelObserver.
 */
class ImageModelObserver
{
    /**
     * @param Image $model
     */
    public function deleted(Image $model)
    {
        $imageTypes = $model->getAllImages();

        foreach ($imageTypes as $images) {
            foreach ($images as $path) {
                \File::delete($path);
            }
        }
    }
}
