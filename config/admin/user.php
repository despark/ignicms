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
            'sourceModel' => \Despark\Cms\Sources\Users\Roles::class,
            'relationTextField' => 'name',
            'validateName' => 'roles',
            'selectedKey' => 'name',
        ],
    ],
];
