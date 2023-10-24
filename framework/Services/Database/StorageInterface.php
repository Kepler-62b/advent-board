<?php

namespace Framework\Services\Database;

interface StorageInterface
{
    public function connect(): void;

    public function get(string $id): ?array;

}