<?php

namespace Despark\Models;

use Illuminate\Database\Eloquent\Model;
use Despark\Admin\Traits\AdminConfigTrait;

abstract class AdminModel extends Model
{
    use AdminConfigTrait;

    protected $identifier;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->adminColumns = config('admin.'.$this->identifier.'.adminColumns');
    }

    public function adminSetFormFields()
    {
        $this->adminFormFields = config('admin.'.$this->identifier.'.adminFormFields');

        return $this;
    }

    public function getImageFields()
    {
        return config('admin.'.$this->identifier.'.imageFields');
    }
}
