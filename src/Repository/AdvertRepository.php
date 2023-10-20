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
        if (is_null($data = $this->storage->selectAllWithOffset($offset))) {
            return [];
        } else {
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

    public function set(string $key, string $value): bool
    {
        return $this->storage->set($key, $value);
    }

    public function hMSet(string $key, array $value)
    {
        return $this->storage->hMSet($key, $value);
    }
}
