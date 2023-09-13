<?php

namespace App\Service;

class HydratorService
{

    public function extract(object $model): array
    {
        $reflection = new \ReflectionClass($model);
        $properties = $reflection->getProperties();
        $propertyStorage = [];
        foreach ($properties as $property) {
            // @TODO реализовать проверку на notNull
            if ($property->isInitialized($model)) {
                $propertyStorage[$property->getName()] = $property->getValue($model);
            }
        }
        return $propertyStorage;
    }

    /**
     * @throws \ReflectionException
     */
    public function hydrate(string $className, array $data, array $map = null): object
    {

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
                    if ($property->getType()->isBuiltin()) {
                        $property->setValue($model, $value);
                    } else {
                        /**
                         * старая функциональность, использующая сеттеры модели
                         * $reflection->getMethod('set' . ucfirst($map[$key]))->invokeArgs($this->model, [$value]);
                         */
                        $propertyType = $property->getType()->getName();

                        // @TODO обработка ManyToOneRelation
                        // @TODO можно проверать instanseOf если ManyToOneRelation будет наследоваться
                        if (str_contains($propertyType, 'ManyToOneRelation')) {
                            $property->setValue($model, new $propertyType($value));
                        } elseif (str_contains($propertyType, 'OneToManyRelation')) {
                            $property->setValue($model, new $propertyType($data['id']));
                        } elseif (str_contains($propertyType, 'Model')) {
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

//                            фековые данные
                            $data = [
                                'id' => 1,
                                'item' => 'item',
                                'description' => 'item desc',
                                'price' => 50000,
                                'image' => 'symfony.png',
                                'created_date' => '2023-06-23 12:57:05',
                                'modified_date' => '2023-06-29 23:57:47',
                            ];

                            $map = [
                                'id' => 'id',
                                'item' => 'item',
                                'description' => 'description',
                                'price' => 'price',
                                'image' => 'image',
                                'created_date' => 'createdDate',
                                'modified_date' => 'modifiedDate',
                            ];

                            $underModel = $this->hydrate($propertyType, $data, $map);
                            //              var_dump($underModel);
                            $property->setValue($model, $underModel);
                        } else {
                            $property->setValue($model, new $propertyType($value));
                        }
                    }
                }
            }
        }
        return $model;
    }

    //  @TODO тестировать метод
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
