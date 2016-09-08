<?php

namespace Despark\Cms\Admin\Observers;

use Despark\Cms\Models\Image;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImageObserver.
 */
class ImageObserver
{

    /**
     * @param Model $model
     */
    public function saved(Model $model)
    {
        $model->saveImages();
    }

    /**
     * @param Image|Model $model
     */
    public function deleted(Model $model)
    {
        $imageInstance = new Image();
        \DB::table($imageInstance->getTable())->where('resource_id', '=', $model->getKey())
           ->delete();

        \File::deleteDirectory($model->getCurrentUploadDir());
    }
}
