<?php

namespace App\Models;

use App\Service\ManyToOneRelation;
use App\Service\OneToManyRelation;
use App\Service\RelationAttribute;

class Image
{
    private ?int $id = null;

    private ?string $name = null;

    private ?string $item_id = null;
    #[RelationAttribute(relationModel: Advert::class)]
    private ?OneToManyRelation $relationModel = null;

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

    public function getItemId(): ?string
    {
        return $this->item_id;
    }

    public function getRelation(): ?OneToManyRelation
    {
        return $this->relationModel;
    }
}
