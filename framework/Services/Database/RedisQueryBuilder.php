<?php

namespace Framework\Services\Database;

class RedisQueryBuilder implements QueryBuilderInterface
{

    private ?array $storage = null;

    public function get(): ?array
    {
        return $this->storage;
    }

    public function set(string $key, mixed $value): void
    {
        $this->storage = [
            $key => $value
        ];
    }

}