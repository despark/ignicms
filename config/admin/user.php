<?php

return [

    'adminColumns' => [
        'name',
        'email',
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
