<?php
namespace Despark\Cms\Models;

use Despark\Cms\Admin\Traits\AdminModelTrait;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
{
    use AdminModelTrait;

    public $identifier = 'role';

    protected $rules = [
        'name' => 'required|unique|max:255'
    ];

    public function getPermissions()
    {
        return Permission::all()->pluck('name', 'name')->toArray();
    }
}
