<?php

namespace App\Service;

class HydratorService
{

  private ?object $model;
  private ?array $map;

  public function __construct(array $map = null)
  {
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

  public function hydrate(string $className, array $data): object
  {
    $this->model = new $className;

    $reflection = new \ReflectionClass($this->model);


    if (!$this->map) {
      foreach ($data as $key => $value) {
        if (array_key_exists($reflection->getProperty($key)->getName(), $data)) {
          $reflection->getProperty($key)->setValue($this->model, $value);
        }
      }
      return $this->model;
    } else {
      foreach ($data as $key => $value) {
        if (array_key_exists($key, $this->map)) {
          // @TODO реализовать добавление строки с датой в объект DataTime не через сеттер
          $propery = $reflection->getProperty($this->map[$key]);
          if ($propery->getType()->isBuiltin()) {
            $propery->setValue($this->model, $value);
          } else {
            /**
             * старая функциональность, использующая сеттеры модели
             * $reflection->getMethod('set' . ucfirst($this->map[$key]))->invokeArgs($this->model, [$value]);
             */
            $className = $propery->getType()->getName();
            $propery->setValue($this->model, new $className($value));
          }
        }
      }
      
      return $this->model;
    }
  }

  public function getThis()
  {
    return $this;
  }
}