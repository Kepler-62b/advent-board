<?php

namespace App\Models;

class AdventHydrate
{
  // @TODO убрать неиспользуесые сеттеры

  private int $id;
  private string $item;
  private string $description;
  private int $price;
  private string $image;

  // @TODO сожержит \DateTimeInterface
  private \DateTimeImmutable $createDate;

  // @TODO сожержит \DateTimeInterface
  private string $modifiedDate;

  public function __construct(string $item, string $description, int $price, string $image)
  {
   $this->item = $item;
   $this->description = $description;
   $this->price = (int) $price;
   $this->image = $image;
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

  public function getCreatedDate(): \DateTimeImmutable
  {
    return $this->createDate;
  }

  public function getModifiedDate(): string
  {
    return $this->modifiedDate;
  }

}