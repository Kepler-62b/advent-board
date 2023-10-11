<?php

namespace App\Models;

use Framework\Services\Attributes\RelationAttribute;
use Framework\Services\OneToManyRelation;

class Image
{
    private ?int $id = null;
    private ?string $name = null;
    private ?int $itemId = null;
    private ?\DateTimeImmutable $createdDate = null;
    private ?\DateTimeImmutable $modifiedDate = null;
    #[RelationAttribute(relationModel: Advert::class)]
    private ?OneToManyRelation $relationModel = null;

    public function __construct(string $name, int $itemId)
    {
        $this->name = $name;
        $this->itemId = $itemId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): ?self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setItemId(int $itemId): ?self
    {
        $this->itemId = $itemId;
        return $this;
    }

    public function getItemId(): ?int
    {
        return $this->itemId;
    }

    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function getModifiedDate(): ?\DateTimeImmutable
    {
        return $this->modifiedDate;
    }

    public function getRelation(): ?OneToManyRelation
    {
        return $this->relationModel;
    }
}
