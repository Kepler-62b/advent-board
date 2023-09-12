<?php

namespace App\Service;

class HydratorService
{

  public function extract(object $model): array
  {
    $reflection = new \ReflectionClass($model);

    $propertyStorage = [];
    foreach ($reflection->getProperties() as $property) {
      // @TODO реализовать проверку на notNull
      if ($property->isInitialized($model)) {
        $propertyStorage[$property->getName()] = $property->getValue($model);
      }
    }
    return $propertyStorage;
  }

  public function hydrate(string $className, array $data, array $map = null): object
  {

    $reflection = new \ReflectionClass($className);

    $model = $reflection->newInstanceWithoutConstructor();

    if (!$map) {
      foreach ($data as $key => $value) {
        if (array_key_exists($reflection->getProperty($key)->getName(), $data)) {
          $reflection->getProperty($key)->setValue($model, $value);
        }
      }
      return $model;
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
            $className = $property->getType()->getName();

            // @TODO обработка RelationManyToOne
            // @TODO можно проверать instanseOf если RelationManyToOne будет наследоваться
            if (str_contains($className, 'RelationManyToOne')) {
              var_dump($className);
              $property->setValue($model, new $className($value));
            } elseif (str_contains($className, 'RelationOneToMany')) {
              $property->setValue($model, new $className($data['id']));
            } else {
              $property->setValue($model, new $className($value));
            }
          }
        }
      }

      return $model;
    }
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