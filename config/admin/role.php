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
            'select_options' => 'getPermissions',
            'relationTextField' => 'name',
            'validateName' => 'permissions',
            'selectedKey' => 'name',
        ],
    ],
];
