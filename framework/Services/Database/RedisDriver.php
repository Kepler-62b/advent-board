<?php

namespace Framework\Services\Database;

class RedisDriver implements DriverInterface
{
    private \Redis $redis;

    public function __construct(
        private string $host,
        private string $port,
    ) {
    }

    public function connect(): void
    {
        try {
            $this->redis = new \Redis();
            $this->redis->pconnect($this->host, $this->port);
        } catch (\RedisException $exception) {
            throw new ConnectionException('Connection Error from RedisStorage / RedisException '.$exception);
        }
    }

    public function get(SQLQueryBuilder $queryBuilder): array
    {
        $key = $queryBuilder->bindValue[0];
        return [$this->redis->get($key)];
    }

    public function set(string $key, string $value, array $options = null): void
    {
        $this->redis->set($key, $value, $options);
    }

    public function getDriverName(): string
    {
        return \Redis::class;
    }
}
