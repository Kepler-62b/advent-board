<?php

namespace Framework\Services\Database;

use Doctrine\Persistence\ObjectRepository;
use Framework\Services\DependencyContainer;
use Framework\Services\HydratorService;
use Framework\Services\NoDBConnectionException;

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
        try {
            $this->storage->connect();
        } catch (ConnectionException $exception) {
            throw new NoDBConnectionException('No database connection');
        }

        if ($this->storage->getStorageName() === SQLStorage::class) {
            [$data] = $this->storage->get($id);

            /** @var RedisStorage $redis */
            $redis = (new DependencyContainer())->get(RedisStorage::class);
            try {
                $redis->connect();
                $redis->set($id, json_encode($data));
            } catch (ConnectionException $exception) {
                throw new NoDBConnectionException('No connect' .\Redis::class);
            }
        } else {
            [$data] = $this->storage->get($id);
            $data = json_decode($data, JSON_OBJECT_AS_ARRAY);
        }

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
        $this->storage->connect();

        // @TODO пиходит null - что делать, чтобы foreach не работал с null
        $data = $this->storage->get(0);
        var_dump($data);

        die;

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