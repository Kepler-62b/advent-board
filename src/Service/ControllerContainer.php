<?php

namespace App\Service;

use App\Repository\AdventRepository;
use App\Controllers\AdventController;

class ControllerContainer
{

  
  
  private array $objects = [];


  public function __construct()
  {
    $this->objects = [
      'App\Service\DatabasePDO' => fn() => new DatabasePDO(),
      'App\Repository\AdventRepository' => fn() => new AdventRepository($this->get('App\Service\DatabasePDO')),
      'App\Controllers\AdventController' => fn() => new AdventController($this->get('App\Repository\AdventRepository')),
    ];
  }

  public function get(string $id): mixed
  {
    return $this->objects[$id]();
  }




}