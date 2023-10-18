<?php

namespace App\Repository;

use Framework\Services\Database\AbstractRepository;
use Framework\Services\Database\StorageInterface;

class AdvertRepository extends AbstractRepository
{
    public function __construct(StorageInterface $storage)
    {
        parent::__construct($storage, Advert::class);
    }

}