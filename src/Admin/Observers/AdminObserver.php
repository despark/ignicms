<?php

namespace Despark\Cms\Admin\Observers;

use Despark\Cms\Admin\Interfaces\UploadFileInterface;
use Despark\Cms\Admin\Interfaces\UploadImageInterface;
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
    public function saved(Model $model)
    {
        if ($model instanceof UploadImageInterface) {
            $model->saveImages();
        }

        if ($model instanceof UploadFileInterface) {
            $model->saveFiles();
        }
    }
}
