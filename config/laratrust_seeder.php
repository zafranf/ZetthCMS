<?php

return [
    'role_structure' => [
        'super' => [
            // 'profile' => 'r,u',
            'dashboard' => 'i',
            'application' => 'i,u',
            'menus' => 'i,c,u,d',
            'roles' => 'i,c,u,d',
            'users' => 'i,c,r,u,d',
        ],
        'admin' => [
            // 'profile' => 'r,u',
            'dashboard' => 'i',
            'application' => 'i,u',
            'users' => 'i,c,r,u,d',
        ],
        'supervisor' => [
            // 'profile' => 'r,u',
            'dashboard' => 'i',
            'users' => 'i,c,r,u,d',
        ],
        'staff' => [
            // 'profile' => 'r,u',
            'dashboard' => 'i',
        ],
        'user' => [
            // 'profile' => 'r,u',
            'dashboard' => 'i',
        ],
    ],
    'permission_structure' => [
        /* 'cru_user' => [
            'profile' => 'c,r,u'
        ], */
    ],
    'permissions_map' => [
        'i' => 'index',
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ]
];
