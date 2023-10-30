<?php

use App\Controllers\AdvertController;
use App\Controllers\ImageController;
use App\Models\Image;
use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;
use Framework\Services\Database\DatabaseConfigs;
use Framework\Services\Database\PDOSQLDriver;
use Framework\Services\Database\RedisDriver;
use Framework\Services\Database\RedisStorage;
use Framework\Services\Database\SQLStorage;
use Framework\Services\Database\StorageFactory;
use Framework\Services\DependencyContainer;

return [
    'container' => [
//        'Framework\Service\Database\PDOConnection' => fn(): PDOConnection => PDOConnection::getInstance(),
        /* сервисы */
        DatabaseConfigs::class => fn(): DatabaseConfigs => new DatabaseConfigs(),
        RedisDriver::class => fn(DependencyContainer $c): RedisDriver => new RedisDriver(...$c->get(DatabaseConfigs::class)->setConfig('Redis')->connect()),
        PDOSQLDriver::class => fn(DependencyContainer $c): PDOSQLDriver => new PDOSQLDriver(...$c->get(DatabaseConfigs::class)->setConfig('PostgreSQL')->connect()),
        SQLStorage::class => fn(DependencyContainer $c): SQLStorage => new SQLStorage($c->get(PDOSQLDriver::class)),
        RedisStorage::class => fn(DependencyContainer $c): RedisStorage => new RedisStorage($c->get(RedisDriver::class)),
        StorageFactory::class => fn(DependencyContainer $c): StorageFactory => new StorageFactory(
            $c->get(PDOSQLDriver::class),
            $c->get(RedisDriver::class)),
        /* репозитории */
        AdvertRepository::class => fn(DependencyContainer $c): AdvertRepository => new AdvertRepository($c->get(StorageFactory::class)->create()),
        ImageRepository::class => fn(DependencyContainer $c): ImageRepository => new ImageRepository($c->get(StorageFactory::class)->create()),
        /* контроллеры */
        AdvertController::class => fn(DependencyContainer $c): AdvertController => new AdvertController($c->get(AdvertRepository::class)),
        ImageController::class => fn(DependencyContainer $c): ImageController => new ImageController($c->get(ImageRepository::class)),
        /* модель для тестирования */
        Image::class => fn(): Image => new Image('container image', 0),
    ],
];
