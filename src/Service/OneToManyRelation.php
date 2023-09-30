<?php

namespace App\Service;

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
        $repository = (object)(new DependencyContainer())->get($modelName);
        // @TODO нужна проверка на instanceOf, чтобы был понятен тип у переменной $repository после маппинга в контейнере зависимостей
        // @TODO для проверки нужно сделать общего предка для всех репозиториев (например, абстрактный класс)

        $repositoryName = get_class($repository);
        // @TODO проверка на существование метода в репозитории
        if (method_exists($repository, 'findById')) {
            $relationModels = $repository->findById($foreignKey);
        } else {
            throw new \BadMethodCallException("NotFoundMethodException: Method 'findById' does not exist in '$repositoryName' repository");
        }

        if (!$relationModels) {
            throw new \DomainException("NotFoundForeignKeyException: Not found relationModel with ID $foreignKey in '$repositoryName'");
        } else {
            return $relationModels;
        }
    }
}
