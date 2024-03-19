<?php

return [
    'PostgreSQL' => [
        'Driver' => 'pgsql',
        'Host' => 'postgres',
        'Port' => '5432',
        'Database' => 'adverts-board',
        'User' => 'postgres',
        'Password' => 'secret',
    ],
    'MySQL' => [
        'Driver' => 'mysql',
        'Host' => 'mysql',
        'Database' => 'adverts-board',
        'User' => 'root',
        'Password' => 'secret',
    ],
    'Redis' => [
        'Host' => 'redis',
        'Port' => '6379',
    ],
];
