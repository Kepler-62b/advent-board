<?php

namespace App\Models;

class Advent
{
  // @TODO убрать неиспользуесые сеттеры

  private int $id;
  private string $item;
  private string $description;
  private int $price;
  private string $image;

  // @TODO сожержит объект \DateTimeImmutable
  private string $createDate;

  // @TODO сожержит объект \DateTimeImmutable
  private string $modifiedDate;


  public function setId(int $id): static
  {
    $this->id = $id;
    return $this;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setItem(string $item): static
  {
    $this->item = $item;
    // @TODO не используемое поведение - возвращать в методе void
    return $this;
  }

  public function getItem(): string
  {
    return $this->item;
  }

  public function setDescription(string $description): static
  {
    $this->description = $description;
    return $this;
  }

  public function getDescription(): string
  {
    return $this->description;
  }

  public function setPrice(int $price): static
  {
    $this->price = $price;
    return $this;
  }

  public function getPrice(): int
  {
    return $this->price;
  }

  public function setImage(string $image): static
  {
    $this->image = $image;
    return $this;
  }

  public function getImage(): string
  {
    return $this->image;
  }

  public function getCreatedDate(): string
  {
    return $this->createDate;
  }

  public function getModifiedDate(): string
  {
    return $this->modifiedDate;
  }

}