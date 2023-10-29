<?php

use App\Controllers\AdvertController;
use App\Controllers\ImageController;
use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;
use Framework\Services\Database\DatabaseConfigs;
use Framework\Services\Database\PDOConnection;
use Framework\Services\Database\PDOSQLDriver;
use Framework\Services\Database\RedisDriver;
use Framework\Services\Database\RedisStorage;
use Framework\Services\Database\SQLStorage;
use Framework\Services\Database\StorageFactory;

return [
    'container' => [
        /* сервисы */
        'Framework\Service\Database\PDOConnection' => fn(): PDOConnection => PDOConnection::getInstance(),

        DatabaseConfigs::class => fn() => new DatabaseConfigs(),
        RedisDriver::class => fn() => new RedisDriver(...$this->get(DatabaseConfigs::class)->setConfig('Redis')),
        PDOSQLDriver::class => fn() => new PDOSQLDriver(...$this->get(DatabaseConfigs::class)->setConfig('PostgreSQL')),

        SQLStorage::class => fn(): SQLStorage => new SQLStorage($this->get(PDOSQLDriver::class)),
        RedisStorage::class => fn(): RedisStorage => new RedisStorage($this->get(RedisDriver::class)),

        StorageFactory::class => fn(): StorageFactory => new StorageFactory(
            $this->get(PDOSQLDriver::class),
            $this->get(RedisDriver::class)),

        /* репозитории */
        AdvertRepository::class => fn(): AdvertRepository => new AdvertRepository($this->get(StorageFactory::class)->create()),
        'App\Repository\ImageRepository' => fn(): ImageRepository => new ImageRepository($this->get('Framework\Service\Database\PDOConnection')),
        /* контроллеры */
        // @TODO не понял, как это должно работать
//            'App\Controllers\AdvertController' => fn(DependencyContainer $c): AdvertController  => new AdvertController($c->get(AdvertRepository::class), new AdvertRepository($c->get('Framework\Services\Database\RedisStorage'))),

        AdvertController::class => fn(): AdvertController => new AdvertController($this->get(AdvertRepository::class)),
        'App\Controllers\ImageController' => fn(): ImageController => new ImageController($this->get('App\Repository\ImageRepository')),
        /* модели */
        'App\Models\Image' => fn(): ImageRepository => new ImageRepository($this->get('Framework\Service\Database\PDOConnection')),
        'App\Models\Advert' => fn(): AdvertRepository => new AdvertRepository($this->get('Framework\Service\Database\PDOConnection')),
    ]
];
