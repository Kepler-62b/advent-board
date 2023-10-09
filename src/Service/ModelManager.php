<?php

namespace App\Service;

class ModelManager
{

  public function __construct(
    private object $model)
  {
  }

  public function get()
  {
   return get_class($this->model);
  }
}