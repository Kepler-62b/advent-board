<?php

namespace App\Service;

use App\Repository\AdventRepository;
use App\Controllers\AdventController;


class ServiceContainer
{
  private array $objects = [];
  public function __construct()
  {
    $this->objects = [
      'App\Service\LinkRender' => fn() => new LinkRender(),
      'App\Service\RenderViewService' => fn() => new RenderViewService($this->get('App\Service\LinkRender'))
    ];
  }

  public function get(string $id): mixed
  {
    return $this->objects[$id]();
  }

  public function has(string $id): bool
  {
    return isset($this->objects[$id]);
  }
}