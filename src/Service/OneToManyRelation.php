<?php

namespace App\Service;

use App\Repository\AdvertRepository;

class OneToManyRelation
{
    public ?array $relationModels = [];

    // @TODO не понятно, нужен ли здесь конструкт
    public function __construct(int $foreignKey, string $modelName)
    {
        $this->relationModels = $this->getDataFromRepository($foreignKey, $modelName);
        // @TODO сделать "ленивую" загрузку связанных моделей
        // $this->relationModels = fn() => $this->getData($foreignKey);
    }

    // @TODO подумать над названием метода
    private function getDataFromRepository(int $foreignKey, string $modelName): ?array
    {
        // @TODO нужна проверка на instanceOf, чтобы был понятен тип у переменной $repository
        /** @var AdvertRepository $repository */
        $repository = (object) (new DependencyContainer())->get($modelName);
        return $repository->findById($foreignKey);
    }
}
