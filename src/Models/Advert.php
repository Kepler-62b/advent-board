<?php

namespace App\Models;

class Advert
{
  // @TODO убрать неиспользуесые сеттеры

  private int $id;
  private string $item;
  private string $description;
  private int $price;
  private string $image;
  private \DateTimeImmutable $createdDate;
  private \DateTimeImmutable $modifiedDate;

  public function __construct(int $id, string $item, string $description, int $price, \DateTimeImmutable $createdDate)
  {
    $this->id = $id;
    $this->item = $item;
    $this->description = $description;
    $this->price = $price;
    $this->createdDate = $createdDate;
  }


  public function getId(): int
  {
    return $this->id;
  }

  public function getItem(): string
  {
    return $this->item;
  }


  public function getDescription(): string
  {
    return $this->description;
  }


  public function getPrice(): int
  {
    return $this->price;
  }


  public function getImage(): string
  {
    return $this->image;
  }

  public function getCreatedDate(): \DateTimeImmutable
  {
    return $this->createdDate;
  }

  public function getModifiedDate(): \DateTimeImmutable
  {
    return $this->modifiedDate;
  }

}