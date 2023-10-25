<?php

namespace Framework\Services\Database;

class RedisStorage implements StorageInterface
{
    public function __construct(
        private DriverInterface $redisDriver,
    ) {
    }

    public function connect(): void
    {
        try {
            $this->redisDriver->connect();
        } catch (ConnectionException $connectionException) {
            throw new ConnectionException('Connection error from RedisStorage'.$connectionException);
        }
    }

    public function get(string $id): ?array
    {
        if (!$data = $this->redisDriver->get($id)) {
            return null;
        } else {
            return $data;
        }
    }

    public function set(string $key, string $value): void
    {
        $this->redisDriver->set($key, $value);
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
