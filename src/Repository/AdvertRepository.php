<?php

namespace App\Repository;

use App\Models\Advert;
use Framework\Services\Database\AbstractRepository;
use Framework\Services\Database\StorageInterface;
use Framework\Services\HydratorService;

class AdvertRepository extends AbstractRepository
{
    public function __construct(StorageInterface $storage)
    {
        parent::__construct($storage, Advert::class);
    }

    public function getAdvertsCount(): int
    {
        var_dump($this->storage);
        $storage = clone $this->storage;
        var_dump($storage);
        return $storage->selectCount();
    }

    public function findAllWithOffest(int $offset): ?array
    {
        $data = $this->storage->selectAllWithOffset($offset);

        $hydrator = new HydratorService();

        $modelsStorage = [];

        foreach ($data as $model) {
            $modelsStorage[] = $hydrator->hydrate(
                $this->entityClass,
                $model,
                [
                    'id' => 'id',
                    'item' => 'item',
                    'description' => 'description',
                    'price' => 'price',
                    'image' => 'image',
                    'created_date' => 'createdDate',
                    'modified_date' => 'modifiedDate',
                ]
            );
        }

        return $modelsStorage;
    }
}
