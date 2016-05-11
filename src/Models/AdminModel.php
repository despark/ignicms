<?php

namespace Despark\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AdminModel extends Model
{
    use AdminConfigTrait;

    protected $identifier;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->adminColumns = config('admin.'.$identifier.'.adminColumns');
    }

    public function adminSetFormFields()
    {
        $this->adminFormFields = config('admin.'.$identifier.'.adminFormFields');

        return $this;
    }

    public function getImageFields()
    {
        return config('admin.'.$identifier.'.imageFields');
    }
}
