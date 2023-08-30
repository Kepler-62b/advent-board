<?php

namespace App\Service;

class HydratorService
{
  private object $model;

  private ?array $map;

  public function __construct(object $model, array $map = null)
  {
    $this->model = $model;
    $this->map = $map;
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

  private function matching(array $map = null, $data = null)
  {
    $reflection = new \ReflectionClass($this->model);

    // START test code block  --------------------------------------
    var_dump($map);
    var_dump($data);
    var_dump($reflection->getProperties());

    foreach ($data as $key => $value) {
      if (array_key_exists($reflection->getProperty($key)->getName(), $data)) {
        $reflection->getProperty($key)->setValue($this->model, $value);
      }
    }
    var_dump($this->model);

    die;
    // return $this->model;

    // END test code block    --------------------------------------


    // START test code block  --------------------------------------
    // var_dump($map);
    // var_dump($data);
    // var_dump($reflection->getProperties());
    // var_dump($reflection->getProperty('id'));


    foreach ($data as $key => $value) {
      if (array_key_exists($key, $map)) {
        $reflection->getProperty($map[$key])->setValue($this->model, $value);
      }
    }

    var_dump($this->model);

    die;
    // return $this->model;

    // END test code block    --------------------------------------


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

  public function hydrate(array $data): object
  {
    $reflection = new \ReflectionClass($this->model);

    if (!$this->map) {
      // var_dump($this->map);
      foreach ($data as $key => $value) {
        if (array_key_exists($reflection->getProperty($key)->getName(), $data)) {
          $reflection->getProperty($key)->setValue($this->model, $value);
        }
      }
      return $this->model;
    } else {
      // var_dump($this->map);
      foreach ($data as $key => $value) {
        if (array_key_exists($key, $this->map)) {
          $reflection->getProperty($this->map[$key])->setValue($this->model, $value);
        }
      }

      return $this->model;
    }



    // START test code block  --------------------------------------

    foreach ($reflection->getProperties() as $property) {
      if (key($data) === $property->getName()) {
        $property->setValue($this->model, current($data));
        next($data);
      }
    }

    // END test code block    --------------------------------------

  }



}