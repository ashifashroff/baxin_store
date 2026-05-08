<?php

return [
    'shop-default' => 'default',

    'shop' => [
        'default' => [
            'name' => 'Default',
            'assets_path' => 'public/themes/shop/default',
            'views_path' => 'resources/themes/default/views',
            'vite' => [
                'hot_file' => 'shop-default-vite.hot',
                'build_directory' => 'themes/shop/default/build',
                'package_assets_directory' => 'src/Resources/assets',
            ],
        ],

        'baxin' => [
            'name' => 'Baxin Store',
            'assets_path' => 'public/themes/shop/baxin',
            'views_path' => 'resources/themes/baxin/views',
            'vite' => [
                'hot_file' => 'themes/shop/baxin/baxin-vite.hot',
                'build_directory' => 'themes/shop/baxin',
                'package_assets_directory' => 'resources/assets',
            ],
        ],
    ],

    'admin-default' => 'default',

    'admin' => [
        'default' => [
            'name' => 'Default',
            'assets_path' => 'public/themes/admin/default',
            'views_path' => 'resources/admin-themes/default/views',
            'vite' => [
                'hot_file' => 'admin-default-vite.hot',
                'build_directory' => 'themes/admin/default/build',
                'package_assets_directory' => 'src/Resources/assets',
            ],
        ],
    ],
];
