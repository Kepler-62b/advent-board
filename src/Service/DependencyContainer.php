<?php

namespace App\Service;

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
        // @TODO подумать над сруктурой массива - контейнера
        $this->objects = [
            // @TODO создание объекта при каждом подключении
//            'App\Service\PHPAdventBoardDatabase' => fn() => new PHPAdventBoardDatabase(),
            'App\Service\PHPAdventBoardDatabase' => fn() => PHPAdventBoardDatabase::getInstance(),

            'App\Repository\AdvertRepository' => fn() => new AdvertRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            'App\Repository\AdventRepository' => fn() => new AdventRepository($this->get('App\Service\PHPAdventBoardDatabase')),

            'App\Controllers\AdventController' => fn() => new AdvertRepository($this->get('App\Repository\PHPAdventBoardDatabase')),

            'App\Models\Image' => fn(): ImageRepository => new ImageRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            'App\Models\Advent' => fn(): AdventRepository => new AdventRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            'App\Models\Advert' => fn(): AdvertRepository => new AdvertRepository($this->get('App\Service\PHPAdventBoardDatabase')),
            // @TODO вторая БД - подумать, как отделить маппинг для других БД
            'App\Service\LaravelDatabase' => fn() => LaravelDatabase::getInstance(),
            'App\Repository\CityRepository' => fn() => new CityRepository($this->get('App\Service\LaravelDatabase')),
            'App\Models\City' => fn() => new CityRepository($this->get('App\Service\LaravelDatabase')),

        ];
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    public function get(string $id): mixed
    {
        // @TODO обрабатывать несуществующие id - будет выбрашено Error
        return $this->objects[$id]();
    }


}