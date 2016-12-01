<?php

return [
    'adminColumns' => [
        'name',
    ],
    'adminFormFields' => [
        'name' => [
            'type' => 'text',
            'label' => 'Name',
        ],
        'permissions[]' => [
            'type' => 'manytomanySelect',
            'label' => 'Permissions',
            'relationMethod' => 'permissions',
            'sourceModel' => \Despark\Cms\Sources\Users\Permissions::class,
            'relationTextField' => 'name',
            'validateName' => 'permissions',
            'selectedKey' => 'name',
        ],
    ],
];
