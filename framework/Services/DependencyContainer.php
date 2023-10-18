<?php

namespace Framework\Services;

use App\Controllers\AdvertController;
use App\Controllers\ImageController;
use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;
use Framework\Services\Database\PDOConnection;
use Framework\Services\Database\SQLStorage;

class DependencyContainer
{
    private array $objects = [];

    public function __construct()
    {
        // @TODO подумать над структурой массива - контейнера
        $this->objects = [
            // @TODO создание объекта при каждом подключении
//            'App\Service\MySQLAdvertsBoard' => fn() => new DatabaseConnection(),
            /** сервисы */
            'Framework\Service\Database\PDOConnection' => fn() => PDOConnection::getInstance(),
            'Framework\Service\Database\SQLStorage' => fn() => new SQLStorage($this->get('Framework\Service\Database\PDOConnection')),
            /** репозитории */
            'App\Repository\AdvertRepository' => fn() => new AdvertRepository($this->get('Framework\Service\Database\SQLStorage')),
            'App\Repository\ImageRepository' => fn() => new ImageRepository($this->get('Framework\Service\Database\PDOConnection')),
            /** контроллеры */
            'App\Controllers\AdvertController' => fn() => new AdvertController($this->get('App\Repository\AdvertRepository')),
            'App\Controllers\ImageController' => fn() => new ImageController($this->get('App\Repository\ImageRepository')),
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