<?php

return [
    'users' => [
        'name' => 'Team',
        'link' => '#',
        'isActive' => false,
        'iconClass' => 'fa-users',
        'permisionsNeeded' => ['manage_users'],
        'subMenu' => [
            'users_manager' => [
                'name' => 'Users Manager',
                'link' => 'admin.users.index',
                'isActive' => false,
                'permisionsNeeded' => ['manage_users'],
            ],
        ],
    ],
];
