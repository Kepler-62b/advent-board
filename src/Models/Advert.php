<?php

namespace App\Models;

use Framework\Services\Attributes\RelationAttribute;
use Framework\Services\ManyToOneRelation;

class Advert implements \JsonSerializable
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

    public function __construct(int $id, string $item, string $description, int $price)
    {
        $this->id = $id;
        $this->item = $item;
        $this->description = $description;
        $this->price = $price;
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

    public function getImage(): ?string
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

    public function getRelation(): ?ManyToOneRelation
    {
        return $this->relationModel;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'item' => $this->item,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'created_date' => $this->createdDate->format('Y-m-d'),
            'modified_date' => $this->modifiedDate->format('Y-m-d'),
        ];
    }

}