<?php

namespace App\Service;

use App\Service\ManyToOneRelation;
use mysql_xdevapi\Exception;
use function PHPUnit\Framework\throwException;

class HydratorService
{
    public function extract(object $model): array
    {
        $reflection = new \ReflectionClass($model);
        $properties = $reflection->getProperties();
        $propertyStorage = [];
        foreach ($properties as $property) {
            // @TODO реализовать свойства проверку на Null
            if ($property->isInitialized($model)) {
                $propertyStorage[$property->getName()] = $property->getValue($model);
            }
        }
        return $propertyStorage;
    }

    /**
     * @param class-string $className
     * @param array<string, string> $data
     * @param array<string, string>|null $map
     * @throws \ReflectionException
     */
    public function hydrate(string $className, array $data, array $map = null): object
    {
        // @TODO может быть использовать какое-то подобие DTO для передачи map - чтобы было понятна структура массива map
        // @TODO создавать stdClass, если $className не передано

        $reflection = new \ReflectionClass($className);

        $model = $reflection->newInstanceWithoutConstructor();

        if (!$map) {
            foreach ($data as $key => $value) {
                if (array_key_exists(key: $reflection->getProperty($key)->getName(), array: $data)) {
                    $reflection->getProperty($key)->setValue($model, $value);
                }
            }
        } else {
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $map)) {

                    $property = $reflection->getProperty($map[$key]);

                    $propertyType = $property->getType() ?? throw new \Exception();

                    if (!$propertyType instanceof \ReflectionNamedType) {
                        throw new \Exception();
                    }

                    if ($propertyType->isBuiltin()) {
                        $property->setValue($model, $value);
                    } else {
                        /**
                         * @TODO отношения в гидраторе 1
                         * получить данные из базы без обработки гидратором и в условии запустить гидратор
                         * на свойстве - объекте с полученными данными - нужен объект, делающий запросы в БД
                         * ЛИБО
                         * @TODO отношения в гидраторе 2
                         * запустить репозиторий по названию объекта, получить из него данные (опять же без гидратора)
                         * и наполнить объект - свойство
                         *
                         * ГЛАВНЫЙ ВОПРОС - КАК ПОЛУЧАТЬ ДАННЫЕ ИЗ БАЗЫ?
                         */

                        $propertyName = $propertyType->getName();

                        if (str_contains($propertyName, 'ManyToOneRelation')) {
                            // @TODO нужно проверять instanseOf от какого-то родителя - ManyToOneRelation будет наследоваться
                            $property->setValue($model, new $propertyName($key, $data['id']));
                        } elseif (str_contains($propertyName, 'OneToManyRelation')) {
                            // @TODO нужно проверять instanseOf от какого-то родителя - OneToManyRelation будет наследоваться

                            $property->setValue($model, new $propertyName($data['id']));
                        } elseif (str_contains($propertyName, 'Models')) {

                            [$attributes] = $property->getAttributes();
                            $attribute = $attributes->getArguments();
                            if ($attribute['relation'] === 'ManyToOneRelation') {
                                $manyToOne = new ManyToOneRelation($propertyName, (int)$data['id']);
                                $property->setValue($model, $manyToOne->references);
                            } elseif ($attribute['relation'] === 'OneToMany') {
//                                $oneToMany = new OneToManyRelation($propertyName, $value);
//                                $property->setValue($model, $oneToMany->references);
                            }
                        } else {
                            /** @var \DateTimeImmutable $propertyName */
                            $propertyObject = new $propertyName($value);

                            $property->setValue($model, $propertyObject);
                        }
                    }
                }
            }
        }

//        $properies = $reflection->getProperties();
//        foreach ($properies as $property) {
//            if ($property->getName() === "imageModel") {
//                var_dump($property->getAttributes());
//                $properyName = $property->getType()->getName();
//                $property->setValue($model, new $properyName((int)$data['id']));
//
//            }
//        }
        return $model;
    }

    //  @TODO тестировать метод и доделать после тестирования
    //  public function hydrateWithConstructor(string $className, array $data, array $map): object
    //  {
    //    $reflection = new \ReflectionClass($className);
    //
    //
    //    foreach ($reflection->getConstructor()->getParameters() as $param) {
    //      $constructPropertyMap[$param->getName()] = $param->getType();
    //    }
    //
    //    foreach ($data as $key => $value) {
    //      if (array_key_exists($map[$key], $constructPropertyMap)) {
    //        $propertyType = $constructPropertyMap[$map[$key]];
    //
    //        if ($propertyType->isBuiltin()) {
    //          $constructArgStorage[] = $value;
    //        } else {
    //          $class = $propertyType->getName();
    //          $constructArgStorage[] = new $class($value);
    //        }
    //      } else {
    //        $notConstructPropertyMap[$value] = $reflection->getProperty($map[$key]);
    //      }
    //    }
    //    $this->model = new $className(...$constructArgStorage);
    //
    //    foreach ($notConstructPropertyMap as $value => $propery) {
    //      if (!$propery->isInitialized($this->model)) {
    //        if ($propery->getType()->isBuiltin()) {
    //          $propery->setValue($this->model, $value);
    //        } else {
    //          $class = $propery->getType()->getName();
    //          $propery->setValue($this->model, new $class($value));
    //        }
    //      }
    //    }
    //
    //    return $this->model;
    //  }
}
