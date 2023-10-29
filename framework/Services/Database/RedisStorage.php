<?php

namespace Framework\Services\Database;

use Framework\Services\Database\RedisQueryBuilder;

class RedisStorage implements StorageInterface
{
    public function __construct(
        private DriverInterface $redisDriver,
    )
    {
    }

    public function connect(): void
    {
        try {
            $this->redisDriver->connect();
        } catch (DriverException $exception) {
            throw new ConnectionException('Connection error from RedisStorage' . $exception);
        }
    }

    public function get(string $id): ?array
    {

        $queryBuilder = (new RedisQueryBuilder());
        $queryBuilder->set(0, $id);

        return $this->redisDriver->get($queryBuilder);

//        if (!$data = $this->redisDriver->get($id)) {
//            return null;
//        } else {
//            return $data;
//        }
    }

    public function set(string $key, mixed $data): void
    {

        $queryBuilder = new RedisQueryBuilder();
        $queryBuilder->set($key, $data);

        $this->redisDriver->set($queryBuilder);
    }

    public function getStorageName(): string
    {
        return RedisStorage::class;
    }

    //
    //    public function selectById($id): ?array
    //    {
    //        if (!($data = $this->redis->get($id))) {
    //            return null;
    //        } else {
    //            return [$id => $data];
    //        }
    //    }
    //
    //    public function selectAll(): array
    //    {
    //        $keys = $this->redis->keys('*');
    //
    //        $values = [];
    //
    //        foreach ($keys as $key) {
    //            //            $values[] = $this->redis->hGetAll($key);
    //            $values[] = json_decode($this->redis->get($key), JSON_OBJECT_AS_ARRAY);
    //        }
    //
    //        return $values;
    //    }
    //
    //    public function set(string $key, string $value): bool
    //    {
    //        return $this->redis->set($key, $value);
    //    }
    //
    //    public function mSet(array $data): bool
    //    {
    //        return $this->redis->mSet($data);
    //    }
    //
    //    public function mSetNx(array $data): bool
    //    {
    //        return $this->redis->msetnx($data);
    //    }
    //
    //    public function hMSet(string $key, array $value)
    //    {
    //        return $this->redis->hMSet($key, $value);
    //    }
}
