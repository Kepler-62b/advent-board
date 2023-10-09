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

    // @TODO не понятно, нужен ли здесь конструкт
    public function __construct(int $relationKey, string $modelName)
    {
        $this->relationModels = $this->getDataFromRepository($relationKey, $modelName);
        // @TODO сделать "ленивую" загрузку связанных моделей
        // $this->relationModels = fn() => $this->getData($foreignKey);
    }

    // @TODO подумать над названием метода
    private function getDataFromRepository(int $relationKey, string $modelName): ?array
    {
        $repository = (object)(new DependencyContainer())->get($modelName);
        // @TODO нужна проверка на instanceOf, чтобы был понятен тип у переменной $repository после маппинга в контейнере зависимостей
        // @TODO для проверки нужно сделать общего предка для всех репозиториев (например, абстрактный класс)

        $repositoryName = get_class($repository);
        if (method_exists($repository, 'findByForeignKey')) {
            $relationModels = $repository->findByForeignKey($relationKey);
        } else {
            throw new \Exception("NotFoundMethodException: Method 'findById' does not exist in '$repositoryName' repository");
        }

        // @TODO надо разбираться с условием - NULL допустимое значение
//        if (!$relationModels) {
//            throw new \Exception("NotFoundForeignKeyException: Not found relationModel with ID $relationKey in '$repositoryName'");
//        } else {
//            return $relationModels;
//        }

        return $relationModels;

    }
}
