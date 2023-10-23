<?php

namespace Framework\Services;

use App\Controllers\AdvertController;
use App\Controllers\ImageController;
use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;
use Framework\Services\Database\AbstractRepository;
use Framework\Services\Database\PDOConnection;
use Framework\Services\Database\SQLStorage;
use Framework\Services\Database\RedisStorage;
use Framework\Services\Database\StorageInterface;

class DependencyContainer
{
    private array $objects = [];

    public function __construct()
    {
        // @TODO подумать над структурой массива - контейнера
        $this->objects = [
            /** сервисы */
            'Framework\Service\Database\PDOConnection' => fn(): PDOConnection => PDOConnection::getInstance(),
            'Framework\Service\Database\SQLStorage' => fn(): SQLStorage => new SQLStorage($this->get('Framework\Service\Database\PDOConnection')),
            'Framework\Services\Database\RedisStorage' => fn(): RedisStorage => new RedisStorage(new \Redis()),
            /** репозитории */
            'App\Repository\AdvertRepository' => fn(): AbstractRepository => new AdvertRepository($this->get('Framework\Service\Database\SQLStorage')),
            'App\Repository\ImageRepository' => fn(): ImageRepository => new ImageRepository($this->get('Framework\Service\Database\PDOConnection')),
            /** контроллеры */
//            'App\Controllers\AdvertController' => fn(DependencyContainer $c): AdvertController  => new AdvertController($c->get(AdvertRepository::class), new AdvertRepository($c->get('Framework\Services\Database\RedisStorage'))),

            'App\Controllers\AdvertController' => fn(): AdvertController  => new AdvertController($this->get('App\Repository\AdvertRepository'), new AdvertRepository(new RedisStorage(new \Redis))),
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