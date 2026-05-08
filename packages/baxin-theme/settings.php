<?php

use BagistoPlus\Visual\Settings\ColorScheme;
use BagistoPlus\Visual\Settings\ColorSchemeGroup;

return [
    [
        'name' => 'Colors',
        'settings' => [
            ColorScheme::make('default_scheme', 'Default Scheme')
                ->default('default'),

            ColorSchemeGroup::make('color_schemes', 'Color Schemes')
                ->schemes([
                    'default' => [
                        'background' => '#ffffff',
                        'on-background' => '#333333',

                        'surface' => '#f5f5f5',
                        'on-surface' => '#333333',

                        'surface-alt' => '#e8e8e8',
                        'on-surface-alt' => '#333333',

                        'primary' => '#1a1a2e',
                        'on-primary' => '#ffffff',

                        'secondary' => '#f5a623',
                        'on-secondary' => '#1a1a2e',

                        'accent' => '#0082ce',
                        'on-accent' => '#ffffff',

                        'neutral' => '#666666',
                        'on-neutral' => '#ffffff',

                        'info' => '#0090b5',
                        'on-info' => '#ffffff',

                        'success' => '#00a43b',
                        'on-success' => '#ffffff',

                        'warning' => '#f5a623',
                        'on-warning' => '#1a1a2e',

                        'danger' => '#ff6266',
                        'on-danger' => '#ffffff',
                    ]
                ])
        ]
    ]
];
