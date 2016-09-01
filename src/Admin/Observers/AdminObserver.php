<?php

namespace Despark\Cms\Admin\Observers;

use Despark\Cms\Admin\Traits\UploadFilesTrait;
use Despark\Cms\Admin\Traits\UploadImagesTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminObserver.
 */
class AdminObserver
{
    /**
     * @param Model $model
     */
    public function saving(Model $model)
    {
        if (in_array(UploadImagesTrait::class, class_uses($model))) {
            $model->saveImages();
        }

        if (in_array(UploadFilesTrait::class, class_uses($model))) {
            $model->saveFiles();
        }
    }
}
