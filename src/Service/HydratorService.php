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

                        $propertyName = $propertyType->getName();

                        /** @var \DateTimeImmutable $propertyName */
                        $propertyObject = new $propertyName($value);

                        $property->setValue($model, $propertyObject);
                    }
                }
            }
        }
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
