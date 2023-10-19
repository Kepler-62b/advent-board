<?php

namespace Framework\Services\Database;

use Doctrine\Persistence\ObjectRepository;
use Framework\Services\HydratorService;

class AbstractRepository implements ObjectRepository
{
    protected StorageInterface $storage;
    protected string $entityClass;

    public function __construct(StorageInterface $storage, string $entityClass)
    {
        $this->storage = $storage;
        $this->entityClass = $entityClass;
    }

    public function find($id): ?object
    {
        $data = $this->storage->selectById($id);

        $hydrator = new HydratorService();
        $model = $hydrator->hydrate(
            $this->entityClass,
            $data,
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

        return $model;
    }

    public function findAll(): array
    {
        $data = $this->storage->selectAll();

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

    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): ?array
    {
        // @TODO заглушка для аргумента $orderBy - в SQLStorage реализованна обработка только строки, а не массива
        $orderBy = current($orderBy);

        if (!$data = $this->storage->selectBy($criteria, $orderBy, $limit, $offset)) {
            return null;
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

    public function findOneBy(array $criteria): ?object
    {
        if ($data = $this->storage->selectByOne($criteria)) {
            return null;
        } else {
            $hydrator = new HydratorService();
            $model = $hydrator->hydrate(
                $this->entityClass,
                $data,
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

            return $model;
        }
    }

    public function getClassName(): object
    {
        return $this->entityClass;
    }


}