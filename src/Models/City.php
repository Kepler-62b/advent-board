<?php

namespace App\Models;

use App\Service\ManyToOneRelation;
use App\Service\Attributes\RelationAttribute;

class City
{
    private ?int $id = null;
    private ?string $cityName = null;
    private ?string $countryCode = null;
    private ?int $population = null;
    private ?\DateTimeImmutable $createdDate = null;
    private ?\DateTimeImmutable $modifiedDate = null;
    private ?\DateTimeImmutable $deletedDate = null;

    public function __construct(int $id, string $cityName, string $countryCode, int $population)
    {
        $this->id = $id;
        $this->cityName = $cityName;
        $this->countryCode = $countryCode;
        $this->population = $population;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function getCountryCode(): ?int
    {
        return $this->countryCode;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function getModifiedDate(): ?\DateTimeImmutable
    {
        return $this->modifiedDate;
    }

    public function deletedDate(): ?\DateTimeImmutable
    {
        return $this->deletedDate;
    }
}