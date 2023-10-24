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
            throw new ConnectionException('Error from RedisStorage' . $exception);
        }
    }

    public function get(string $id): array
    {
        return [$this->redis->get($id)];
    }

    public function set(string $key, string $value, array $options = null): void
    {
        $this->redis->set($key, $value, $options);
    }

}