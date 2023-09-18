<?php

namespace App\Service;

class OneToManyRelation
{
    public ?array $relationModels = [];

    public function __construct(int $foreignKey, string $modelName)
    {
        $this->relationModels = $this->getDataFromRepository($foreignKey, $modelName);
        // @TODO сделать "ленивую" загрузку связанных моделей
        // $this->relationModels = fn() => $this->getData($foreignKey);
    }

    // @TODO подумать над названием метода
    private function getDataFromRepository(int $foreignKey, string $modelName): ?array
    {
        $repository = (object) (new ControllerContainer())->get($modelName);
        return $repository->findById($foreignKey);
    }
}
