<?php

namespace App\Service;

class ManyToOneRelation
{
    /**
     * @TODO подумать, как отдавать конкретную связанную модель из массива моделей
     */

    // @TODO подумать над названием свойства
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
        $objectArray = $repository->findByForeignKey($foreignKey);
        return $objectArray;
    }
}
