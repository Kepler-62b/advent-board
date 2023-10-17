<?php

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'localhost',
        'wsl-docker-container' => [
            'adapter' => 'pgsql',
            'host' => 'adverts-postgres',
            'name' => 'adverts-board',
            'user' => 'postgres',
            'pass' => 'secret',
            'port' => '5432',
            'charset' => 'utf8',
        ],
        'localhost' => [
            'adapter' => 'pgsql',
            'host' => 'localhost',
            'name' => 'adverts-board',
            'user' => 'postgres',
            'pass' => 'secret',
            'port' => '5432',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
