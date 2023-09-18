<?php

namespace App\Service;

use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;

class ManyToOneRelation
{
    /**
     * @TODO подумать, как отдавать конкретную связанную модель из массива моделей
     */

    // @TODO подумать над названием свойства
    public ?array $relationModels = [];

    public function __construct(int $relationKey, string $modelName)
    {
        $this->relationModels = $this->getDataFromRepository($relationKey, $modelName);
        // @TODO сделать "ленивую" загрузку связанных моделей
        // $this->relationModels = fn() => $this->getData($foreignKey);
    }

    // @TODO подумать над названием метода
    private function getDataFromRepository(int $relationKey, string $modelName): ?array
    {
        // @TODO нужна проверка на instanceOf, чтобы был понятен тип у переменной $repository - репозитории должны наследоваться
        /** @var ImageRepository $repository */
        $repository = (object) (new ControllerContainer())->get($modelName);

        return $repository->findByForeignKey($relationKey);
    }
}
