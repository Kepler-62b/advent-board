<?php

namespace Framework\Services\Database;

class RedisDriver implements DriverInterface
{
    private \Redis $redis;

    public function __construct(
        private string $host,
        private string $port,
    )
    {
    }

    public function connect(): void
    {
        try {
            $this->redis = new \Redis();
//            var_dump($this->redis);
            $this->redis->pconnect($this->host, $this->port);
        } catch (\RedisException $exception) {
            throw new DriverException('RedisException / ' . $exception);
        }
    }

    public function get(RedisQueryBuilder $queryBuilder): array
    {
        $key = $queryBuilder->get();
        return [$this->redis->get(current($key))];
    }

    public function set(RedisQueryBuilder $queryBuilder): void
    {
        $data = $queryBuilder->get();
        $key = key($data);
        $value = current($data);

        $this->redis->set($key, $value);
    }

    public function getDriverName(): string
    {
        return RedisDriver::class;
    }
}
