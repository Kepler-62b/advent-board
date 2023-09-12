<?php

namespace App\Models;

use App\Service\RelationManyToOne;

class Image
{
  private ?int $id = null;

  private ?string $name = null;

  private ?RelationManyToOne $item_id = null;

  public function setId(int $id): static
  {
    $this->id = $id;
    return $this;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setName(string $name): static
  {
    $this->name = $name;
    return $this;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function getItemId(): ?RelationManyToOne
  {
    return $this->item_id;
  }
}