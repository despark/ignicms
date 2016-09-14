<?php

namespace Despark\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Despark\Cms\Admin\Traits\AdminConfigTrait;

abstract class AdminModel extends Model
{
    use AdminConfigTrait;

    public $identifier;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->adminColumns = config('admin.'.$this->identifier.'.adminColumns');

        $this->saved(function ($model) {
            if ($model->getImageFields()) {
                $this->saveImages();
            }

            if ($model->getFileFields()) {
                $model->saveFiles();
            }
        });
    }

    public function adminSetFormFields()
    {
        $this->adminFormFields = config('admin.'.$this->identifier.'.adminFormFields');

        return $this;
    }

    public function getImageFields()
    {
        return config('admin.'.$this->identifier.'.image_fields');
    }

    public function getFileFields()
    {
        return config('admin.'.$this->identifier.'.file_fields');
    }
}
