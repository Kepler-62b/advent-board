<?php

namespace App\Service;

// @TODO подумать над названием класса
class RelationObject
{
    private object $model;

    public function __construct(object $model)
    {
        $this->model = $model;
    }

    public function getRelation(string $relationColumn): object
    {
        // @TODO подумать какому объекту пердавать репозиторий
        // @TODO использовать аттрибуты с именем модели (сущьности)
        $reflection = new \ReflectionClass($this->model);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            if ($property->getName() === $relationColumn) {
                $propertyHasRelation = $property->getValue($this->model);
            }

            $propertyType = $property->getType();
            if (!$propertyType->isBuiltin()) {
                $propertyName = $propertyType->getName();
                // @TODO подумать над условием проверки
                if (str_contains($propertyName, "Relation")) {
                    // @TODO подумать, как получать значение атрибута
                    // @TODO нужно проверять instanseOf от какого-то родителя
                    [$attributes] = $property->getAttributes();
                    $attribute = $attributes->getArguments();

                    $property->setValue($this->model, new $propertyName($propertyHasRelation, $attribute['relationModel']));
                }
            }
        }
        return $this->model;
    }
}