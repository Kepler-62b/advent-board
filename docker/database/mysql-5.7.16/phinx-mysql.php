<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'localhost',
        'wsl-docker-container' => [
            'adapter' => 'mysql',
            'host' => 'adverts-mysql',
            'name' => 'adverts-board',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'localhost' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1',
            'name' => 'adverts-board',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
