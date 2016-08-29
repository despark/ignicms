<?php

namespace Despark\Cms\Models;

use Despark\Cms\Admin\Traits\AdminModelTrait;
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use AdminModelTrait;

    public $identifier = 'permission';

    protected $rules = [
        'name' => 'required|unique:permissions|max:255',
    ];

    protected $rulesUpdate = [
        'name' => 'required|max:255',
    ];
}
