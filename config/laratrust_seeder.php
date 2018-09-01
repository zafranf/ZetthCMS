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
            'subscribers' => 'i,u,d',
            'categories' => 'i,c,u,d',
            'tags' => 'i,c,u,d',
            'banners' => 'i,c,u,d',
            'posts' => 'i,c,r,u,d',
            'pages' => 'i,c,r,u,d',
            'photos' => 'i,c,u,d',
            'videos' => 'i,c,u,d',
            'inbox' => 'i,r,d',
            'comments' => 'i,c,r,u,d',
            'interms' => 'i',
        ],
        'admin' => [
            // 'profile' => 'r,u',
            'dashboard' => 'i',
            'application' => 'i,u',
            'users' => 'i,c,r,u,d',
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
