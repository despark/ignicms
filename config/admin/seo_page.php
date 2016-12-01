<?php

return [
    'adminColumns' => [
        'page_title',
    ],
    'adminFormFields' => [
        'page_title' => [
            'type' => 'text',
            'label' => 'Page title',
        ],
        'page_slug' => [
            'type' => 'text',
            'label' => 'Page slug',
        ],
        'meta_title' => [
            'type' => 'text',
            'label' => 'Meta title',
        ],
        'meta_description' => [
            'type' => 'text',
            'label' => 'Meta description',
        ],
        'meta_title' => [
            'type' => 'text',
            'label' => 'Meta title',
        ],
        'meta_image' => [
            'type' => 'imageSingle',
            'label' => 'Meta image',
            'help' => 'The meta image should be at least 1200x630px and with the same aspect ratio.',
        ],
    ],
    'image_fields' => [
        'meta_image' => [
            'thumbnails' => [
                'admin' => [
                    'width' => 150,
                    'height' => null,
                    'type' => 'resize',
                ],
                'normal' => [
                    'width' => 1200,
                    'height' => 630,
                    'type' => 'crop',
                ],
            ],
        ],
    ],
];
