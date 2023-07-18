<?php

namespace App\Models;

class Image
{
  private int $id;

  private string $name;

  private int $item_id;

  public function setId(int $id): static
  {
    $this->id = $id;
    return $this;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setName(string $name): static
  {
    $this->name = $name;
    return $this;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setItemId(int $item_id): static
  {
    $this->item_id = $item_id;
    return $this;
  }

  public function getItemId(): int
  {
    return $this->item_id;
  }
}