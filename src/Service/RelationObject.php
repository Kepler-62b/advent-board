<?php

namespace App\Service;

class RelationObject
{
    private object $model;

    public function __construct(object $model)
    {
        $this->model = $model;
    }

    public function manyToOne(string $id, string $foreignKey = null)
    {
        // @TODO подумать над названием свойства для поиска отношения
        // @TODO подумать какому объекту пердавать репозиторий
        // @TODO использовать аттрибуты с именем модели (сущьности)
        $reflection = new \ReflectionClass($this->model);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            if ($property->getName() === $id) {
                $propertyHasId = $property->getValue($this->model);
            }

            $propertyType = $property->getType();
            if (!$propertyType->isBuiltin()) {
                $propertyName = $propertyType->getName();
                if (str_contains($propertyName, "ManyToOneRelation")) {
                    $property->setValue($this->model, new $propertyName($propertyHasId));
                }
            }
        }
        return $this->model;
    }


}