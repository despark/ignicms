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
     * @param ImageContract|Image $model
     */
    public function saving(ImageContract $model)
    {
        // Extract image attributes from model
        if (! empty($meta = $model->getAttribute('meta'))) {
            foreach ($model->getImageAttributeFields() as $fieldName) {
                if (array_key_exists($fieldName, $meta)) {
                    $model->setAttribute($fieldName, $meta[$fieldName]);
                    $model->$fieldName = $model->meta[$fieldName];
                    unset($meta[$fieldName]);
                }
            }
            $model->setAttribute('meta', $meta);
        }
    }

    /**
     * @param ImageContract|Image $model
     */
    public function deleted(ImageContract $model)
    {
        $imageTypes = $model->getAllImages();

        foreach ($imageTypes as $images) {
            foreach ($images as $path) {
                \File::delete(public_path($path));
            }
        }
    }
}
