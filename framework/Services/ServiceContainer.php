<?php

namespace Framework\Services;

use App\Controllers\AdventController;
use App\Repository\AdventRepository;


class ServiceContainer
{
  private array $objects = [];
  public function __construct()
  {
    $this->objects = [
      'Framework\Service\LinkRender' => fn() => new LinkRender(),
      'Framework\Service\RenderViewService' => fn() => new RenderViewService($this->get('Framework\Service\LinkRender'))
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