<?php

return [
    'projectName' => 'Despark',
    'defaultFormView' => 'ignicms::admin.formElements.defaultForm',
    'paginateLimit' => 15,
    'paths' => [
        'model' => app_path('Models'),
        'request' => app_path('Http/Requests/Admin'),
        'controller' => app_path('Http/Controllers/Admin'),
        'migration' => base_path('database/migrations'),
        'config' => base_path('config/admin'),
    ],
];
