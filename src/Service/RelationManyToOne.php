<?php

namespace App\Service;

use App\Repository\AdventRepository;

class RelationManyToOne
{
  public int $foreignKey;
  public object $references;

  public function __construct(int $foreignKey)
  {
    $this->foreignKey = $foreignKey;
    $this->references = $this->getData($foreignKey);
  }

  private function getData(int $foreignKey): object
  {
    $repository = new AdventRepository(new DatabasePDO());
    [$object] = $repository->findById($foreignKey);
    return $object;
  }


}