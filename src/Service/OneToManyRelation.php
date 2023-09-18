<?php

namespace App\Service;

class OneToManyRelation
{
    public array $relationModels = [];

    public function __construct(int $foreignKey, string $modelName)
    {
        $this->relationModels = $this->getData($foreignKey, $modelName);
        // @TODO сделать "ленивую" загрузку связанных моделей
        // $this->relationModels = fn() => $this->getData($foreignKey);
    }

    // @TODO подумать над названием метода
    private function getData(int $foreignKey, string $modelName)
    {
        $repository = (new ControllerContainer())->get($modelName);
        $objectArray = $repository->findById($foreignKey);
        return $objectArray;
    }
}
