<?php

namespace Framework\Services\Database;

class RedisStorage implements StorageInterface
{
    private \Redis $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
        try {
            $this->redis->connect('adverts-redis', 6379);
        } catch (\RedisException $exception) {
            throw new \RedisException('Error from RedisStorage');
        }
    }

    public function selectById($id): ?array
    {
        if (!($data = $this->redis->get($id))) {
            return null;
        } else {
            return [$id => $data];
        }
    }

    public function selectAll(): array
    {
        $keys = $this->redis->keys('*');

        $values = [];

        foreach ($keys as $key) {
//            $values[] = $this->redis->hGetAll($key);
            $values[] = json_decode($this->redis->get($key), JSON_OBJECT_AS_ARRAY);
        }

        return $values;
    }

    public function selectBy(array|string $criteria = null, array|string $orderBy = null, int $limit = null, int $offset = null)
    {
        // TODO: Implement selectBy() method.
    }

    public function selectByOne(array $criteria)
    {
        // TODO: Implement selectByOne() method.
    }

    public function selectAllWithOffset(int $offset)
    {

    }

    public function set(string $key, string $value): bool
    {
        return $this->redis->set($key, $value);
    }

    public function mSet()
    {
        return $this->redis->mSet();
    }

    public function hMSet(string $key, array $value)
    {
        return $this->redis->hMSet($key, $value);
    }

}