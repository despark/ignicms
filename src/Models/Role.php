<?php

namespace Despark\Cms\Models;

use Despark\Cms\Admin\Traits\AdminModelTrait;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
{
    use AdminModelTrait;

    public $identifier = 'role';

    protected $rules = [
        'name' => 'required|unique:roles|max:255',
    ];

    protected $rulesUpdate = [
        'name' => 'required|max:255',
    ];

    protected static function getPermissions()
    {
        return Permission::all()->pluck('name', 'name')->toArray();
    }
}
