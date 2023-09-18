<?php

namespace App\Service;

use App\Repository\AdventRepository;
use App\Controllers\AdventController;
use App\Repository\ImageRepository;

class ControllerContainer
{

    private array $objects = [];


    public function __construct()
    {
        $this->objects = [
            'App\Service\PDOMySQL' => fn() => new PDOMySQL(),
            'App\Repository\AdventRepository' => fn() => new AdventRepository($this->get('App\Service\PDOMySQL')),
            'App\Controllers\AdventController' => fn() => new AdventController($this->get('App\Repository\AdventRepository')),
            // @TODO подумать над сруктурой массива - контейнера
            'App\Models\Image' => fn(): ImageRepository => new ImageRepository($this->get('App\Service\PDOMySQL')),
            'App\Models\Advert' => fn(): AdventRepository => new AdventRepository($this->get('App\Service\PDOMySQL')),
        ];
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    public function get(string $id): mixed
    {
        return $this->objects[$id]();
    }


}