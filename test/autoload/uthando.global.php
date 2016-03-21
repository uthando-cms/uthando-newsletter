<?php

return [
    'load_uthando_configs' => true,
    'php_settings' => [
        'display_startup_errors'        => true,
        'display_errors'                => true,
        'error_reporting'               => E_ALL ^ E_USER_DEPRECATED,
        'max_execution_time'            => 60,
        'date.timezone'                 => 'Europe/London',
    ],
    'theme_manager' => [
        'site_name'         => 'Uthando CMS',
        'default_theme'     => 'default',
        'admin_theme'       => 'admin',
        'theme_path'        => './public/themes/',
        'bootstrap'         => true,
        'bootswatch_theme'  => null,
        'font_awesome'      => true,
    ],
];
