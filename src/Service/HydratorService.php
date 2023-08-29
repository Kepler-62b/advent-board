<?php

namespace App\Service;

class HydratorService
{
  private object|string $model;

  public function __construct(object|string $model)
  {
    $this->model = $model;
  }

  public function getConstructProperty(): array
  {
    $reflection = new \ReflectionClass($this->model);

    $constuctor = $reflection->getConstructor();
    $constructorParams = $constuctor->getParameters();
    $param = $constructorParams[2];

    $paramsStorage = [];
    foreach ($constructorParams as $param) {
      $paramsStorage[] = $param->getName();
    }
    return $paramsStorage;

  }


  public function extract(): array
  {

    $reflection = new \ReflectionClass($this->model);

    $propertyStorage = [];
    foreach ($reflection->getProperties() as $property) {
      if ($property->isInitialized($this->model)) {
        $propertyStorage[$property->getName()] = $property->getValue($this->model);
      }
    }
    return $propertyStorage;

  }
  public function hydrate(array $data)
  {
    $reflection = new \ReflectionClass($this->model);

    foreach ($reflection->getProperties() as $property) {
      if (key($data) === $property->getName()) {
        $property->setValue($this->model, current($data));
      } else {
        $property->setValue($this->model, next($data));

      }
    }
    return $this->model;


  }



}