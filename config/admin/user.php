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
        'images_upload_1' => [
            'type' => 'image',
            'label' => 'Image (landscape)',
            'orientation' => '1',
            'help' => 'Image size should be at least 1804 x 1150 and with the same aspect ratio',
        ],
        'images_upload_2' => [
            'type' => 'image',
            'label' => 'Image (portrait)',
            'orientation' => '2',
            'help' => 'There will be help text: “Image size should be at least 452 x 600 and with the same aspect ratio',
        ],
        'password' => [
            'type' => 'password',
            'label' => 'Password',
        ],
    ],

];
