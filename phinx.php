<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/docker/database/postgres/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/docker/database/postgres/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'pgsql',
            'host' => 'adverts-postgres',
            'name' => 'adverts-board',
            'user' => 'postgres',
            'pass' => 'secret',
            'port' => '5432',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'pgsql',
            'host' => 'localhost',
            'name' => 'adverts-board',
            'user' => 'postgres',
            'pass' => 'secret',
            'port' => '5432',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host' => 'adverts-postgres',
            'name' => 'adverts',
            'user' => 'postgres',
            'pass' => 'secret',
            'port' => '5432',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
