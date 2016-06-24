<?php

namespace Despark\Cms\Models;

use Zizaco\Entrust\EntrustRole;
use Despark\Cms\Admin\Traits\AdminConfigTrait;

/**
 * Class Role.
 */
class Role extends EntrustRole
{
    use AdminConfigTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'name' => 'required|unique:roles,name|regex:/^\w+$/',
        'display_name' => 'required',
        'description' => 'required',
        'permissions' => 'required',
    ];

    protected $rulesUpdate = [
        'name' => 'required|regex:/^\w+$/',
        'display_name' => 'required',
        'description' => 'required',
        'permissions' => 'required',
    ];

    /**
     * Role constructor.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->adminColumns = [
            ['name' => 'Name', 'db_field' => 'name'],
            ['name' => 'Display name', 'db_field' => 'display_name'],
            ['name' => 'Description', 'db_field' => 'description'],
        ];

        $this->adminFilters = [
            'text_search' => [
                'db_fields' => [
                    'name',
                    'display_name',
                    'description',
                ],
            ],
        ];

        if ($this->hasFilters()) {
            return $this->filtering();
        }
    }

    public function adminSetFormFields()
    {
        $this->adminFormFields = [
            'name' => [
                'type' => 'text',
                'label' => 'Name',
            ],
            'display_name' => [
                'type' => 'text',
                'label' => 'Display name',
            ],
            'description' => [
                'type' => 'textarea',
                'label' => 'Description',
            ],
            'permissions[]' => [
                'type' => 'manytomanySelect',
                'label' => 'Permissions',
                'relationMethod' => 'perms',
                'select_options' => Permission::all()->pluck('display_name', 'id'),
                'relationTextField' => 'display_name',
                'validateName' => 'permissions',
                'selectedKey' => 'id',
            ],
        ];

        return $this;
    }
}
