<?php

namespace App\Service;

use App\Models\Advent;
use App\Models\Image;
use App\Repository\AdventRepository;
use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;

class ManyToOneRelation
{
    // @TODO подумать над названием свойства
    public array $relationModels = [];

    public function __construct(int $foreignKey, string $modelName = null)
    {
        $this->relationModels = $this->getData($foreignKey, $modelName);
//        $this->relationModels = fn() => $this->getData($foreignKey);
    }

    private function getData(int $foreignKey, string $modelName)
    {
        $repository = (new ControllerContainer())->get($modelName);
        $objectArray = $repository->findByForeignKey($foreignKey);
        return $objectArray;
    }
}
