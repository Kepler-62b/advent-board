<?php

namespace App\Models;

class Image
{
    private ?int $id = null;

    private ?string $name = null;

    private ?Advent $item_id = null;

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

    public function getItemId(): ?Advent
    {
        return $this->item_id;
    }
}
