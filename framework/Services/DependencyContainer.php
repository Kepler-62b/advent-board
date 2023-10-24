<?php

namespace Framework\Services;

use App\Controllers\AdvertController;
use App\Controllers\ImageController;
use App\Models\Image;
use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;
use Framework\Services\Database\DatabaseConfigs;
use Framework\Services\Database\LoggerStorageDecorator;
use Framework\Services\Database\PDOConnection;
use Framework\Services\Database\PDOSQLDriver;
use Framework\Services\Database\RedisDriver;
use Framework\Services\Database\StorageFactory;

class DependencyContainer
{
    private array $objects = [];

    // @TODO вынести зависимости из класса в отдельный файл
    public function __construct()
    {
        $this->objects = [
            /** сервисы */
            'Framework\Service\Database\PDOConnection' => fn(): PDOConnection => PDOConnection::getInstance(),

            DatabaseConfigs::class => fn() => new DatabaseConfigs(),
            RedisDriver::class => fn() => new RedisDriver(...$this->get(DatabaseConfigs::class)->setConfig('Redis')),
            PDOSQLDriver::class => fn() => new PDOSQLDriver(...$this->get(DatabaseConfigs::class)->setConfig('PostgreSQL')),
            StorageFactory::class => fn() => new StorageFactory(
                $this->get(PDOSQLDriver::class),
                $this->get(RedisDriver::class)),

            /** репозитории */
            AdvertRepository::class => fn(): AdvertRepository => new AdvertRepository($this->get(StorageFactory::class)->create()),
            'App\Repository\ImageRepository' => fn(): ImageRepository => new ImageRepository($this->get('Framework\Service\Database\PDOConnection')),
            /** контроллеры */
            // @TODO не понял, как это должно работать
//            'App\Controllers\AdvertController' => fn(DependencyContainer $c): AdvertController  => new AdvertController($c->get(AdvertRepository::class), new AdvertRepository($c->get('Framework\Services\Database\RedisStorage'))),

            AdvertController::class => fn(): AdvertController => new AdvertController($this->get(AdvertRepository::class)),
            'App\Controllers\ImageController' => fn(): ImageController => new ImageController($this->get('App\Repository\ImageRepository')),
            /** модели */
            'App\Models\Image' => fn(): ImageRepository => new ImageRepository($this->get('Framework\Service\Database\PDOConnection')),
            'App\Models\Advert' => fn(): AdvertRepository => new AdvertRepository($this->get('Framework\Service\Database\PDOConnection')),
        ];
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    /**
     * @param class-string $id
     * @throws \Exception
     */
    public function get(string $id): mixed
    {
        // @TODO обрабатывать несуществующие id - будет выбрашено Error
        if (array_key_exists($id, $this->objects)) {
            return $this->objects[$id]();
        } else {
            throw new \Exception("'$id' not exist in DependencyContainer");
        }
    }
}