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

    /**
     * @throws \Exception
     */
    public function getRelation(string $relationColumn): object
    {
        // @TODO подумать какому объекту пердавать репозиторий
        // @TODO использовать аттрибуты с именем модели (сущьности)
        $reflection = new \ReflectionClass($this->model);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {

            if ($property->getName() === $relationColumn) {
                // @TODO $propertyHasRelationKey должно быть int - прописать проверку типа
                if (is_numeric($property->getValue($this->model))) {
                    $propertyHasRelationKey = $property->getValue($this->model);
                }
            }

            $propertyType = $property->getType() ?? throw new \Exception();

            if (!$propertyType instanceof \ReflectionNamedType) {
                throw new \Exception();
            }

            if (!$propertyType->isBuiltin()) {
                $propertyName = $propertyType->getName();
                // @TODO подумать над условием проверки
                if (str_contains($propertyName, "Relation")) {
                    // @TODO подумать, как получать значение атрибута
                    // @TODO нужно проверять instanseOf от какого-то родителя
                    [$attributes] = $property->getAttributes();
                    $attribute = $attributes->getArguments();

                    if(!isset($propertyHasRelationKey)) {
                        throw new \Exception();
                    }

                    /** @var ManyToOneRelation|OneToManyRelation $propertyName */
                    $property->setValue($this->model, new $propertyName($propertyHasRelationKey, $attribute['relationModel']));
                }
            }
        }
        return $this->model;
    }
}