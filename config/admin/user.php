<?php

return [

    'adminColumns' => [
        ['name' => 'Name', 'db_field' => 'name'],
        ['name' => 'Email', 'db_field' => 'email'],
    ],
    'adminFormFields' => [
        'name' => [
            'type' => 'text',
            'label' => 'Name',
        ],
        'email' => [
            'type' => 'text',
            'label' => 'Email',
        ],
        'password' => [
            'type' => 'password',
            'label' => 'Password',
        ],
        'roles[]' => [
            'type' => 'manytomanySelect',
            'label' => 'Roles',
            'relationMethod' => 'roles',
            'select_options' => 'rolesOptions',
            'relationTextField' => 'name',
            'validateName' => 'roles',
            'selectedKey' => 'name',
        ],
    ],

];
