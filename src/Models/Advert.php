<?php

namespace App\Models;

use App\Service\ManyToOneRelation;
use App\Service\OneToManyRelation;
use App\Service\RelationAttribute;

class Advert
{
    // @TODO убрать неиспользуесые сеттеры

    private ?int $id = null;
    private ?string $item = null;
    private ?string $description = null;
    private ?int $price = null;
    private ?string $image = null;
    private ?\DateTimeImmutable $createdDate = null;
    private ?\DateTimeImmutable $modifiedDate = null;

    #[RelationAttribute(relationModel: Image::class)]
    private ?ManyToOneRelation $relationModel = null;

    public function __construct(int $id, string $item, string $description, int $price, \DateTimeImmutable $createdDate)
    {
        $this->id = $id;
        $this->item = $item;
        $this->description = $description;
        $this->price = $price;
        $this->createdDate = $createdDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function getModifiedDate(): ?\DateTimeImmutable
    {
        return $this->modifiedDate;
    }

}