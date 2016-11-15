<?php

return [
    'files' => [
        // No leading slash
        'temporary_directory' => 'temp_uploads',
    ],
    'images' => [
        // Retina factor. User null or false if you don't want retina images to be generated.
        'retina_factor' => 2,
        'max_upload_size' => 5000,
        'admin_thumb_width' => 200,
        'admin_thumb_height' => 200,
        'admin_thumb_type' => 'fit',
        'disable_alt_title_fields' => false,
    ],
    'admin_assets' => [
        'js' => [
            'js/admin.js',
        ],
        'css' => [
            //'css/styles.css',
            '/css/admin.css',
        ],
    ],
];
