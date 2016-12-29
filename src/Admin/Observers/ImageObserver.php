<?php

namespace Despark\Cms\Admin\Observers;

use Illuminate\Database\Eloquent\Model;
use Despark\Cms\Contracts\ImageContract;

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
     * @param Model $model
     */
    public function deleted(Model $model)
    {
        $imageInstance = app(ImageContract::class);
        \DB::table($imageInstance->getTable())->where('resource_id', '=', $model->getKey())
           ->delete();

        \File::deleteDirectory($model->getCurrentUploadDir());
    }
}
