<?php
return [
    'banner' => [
        'single' => true,
        'image' => [
            'dimension' => [
                'width' => 1280,
                'height' => 768,
            ],
            'ratio' => '16:9',
            'weight' => 512,
        ],
    ],
    'post' => [
        'cover' => [
            'dimension' => [
                'width' => 1280,
                'height' => 768,
            ],
            'ratio' => '16:9',
            'weight' => 512,
        ],
    ],
    'menu' => [
        'options' => [
            'main' => [
                'wrapper' => [
                    'tag' => 'div',
                    'class' => 'navbar-start ',
                ],
                'list' => false,
                'link' => [
                    'tag' => 'a',
                    'class' => 'navbar-item is-danger',
                    'active' => true,
                    'active_class' => 'has-text-danger has-background-white-bis',
                    'additional' => [
                        'position' => 'before',
                    ],
                ],
            ],
        ],
    ],
];
