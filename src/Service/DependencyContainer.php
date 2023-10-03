<?php

namespace App\Service;

use App\Controllers\AdventController;
use App\Controllers\AdvertController;
use App\Controllers\DefaultController;
use App\Controllers\ImageController;
use App\Models\Advent;
use App\Repository\AdventRepository;
use App\Repository\AdvertRepository;
use App\Repository\CityRepository;
use App\Repository\ImageRepository;

class DependencyContainer
{

    private array $objects = [];


    public function __construct()
    {
        // @TODO подумать над структурой массива - контейнера
        $this->objects = [
            // @TODO создание объекта при каждом подключении
            /** база данных */
//            'App\Service\PHPAdventBoardDatabase' => fn() => new PHPAdventBoardDatabase(),
            'App\Service\PHPAdventBoardDatabase' => fn() => PHPAdventBoardDatabase::getInstance(),
            /** репозитории */
            'App\Repository\AdventRepository' => fn() => new AdventRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            'App\Repository\AdvertRepository' => fn() => new AdvertRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            'App\Repository\ImageRepository' => fn() => new ImageRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            /** контроллеры */
            'App\Controllers\AdventController' => fn() => new AdventController($this->get('App\Repository\AdventRepository')),
            'App\Controllers\AdvertController' => fn() => new AdvertController($this->get('App\Repository\AdvertRepository')),
            'App\Controllers\ImageController' => fn() => new ImageController($this->get('App\Repository\ImageRepository')),
            /** модели */
            'App\Models\Image' => fn(): ImageRepository => new ImageRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            'App\Models\Advent' => fn(): AdventRepository => new AdventRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            'App\Models\Advert' => fn(): AdvertRepository => new AdvertRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            // @TODO вторая БД - подумать, как отделить маппинг для других БД
            'App\Service\PostgresAdvertsBoard' => fn() => PostgresAdvertsBoard::getInstance(),
            /** разные службы */
            'App\Controllers\DefaultController' => fn() => new DefaultController(),
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