<?php

namespace Framework\Services\Database;

interface StorageInterface
{
    /** @throws ConnectionException */
    public function connect(): void;

    public function get(string $id): ?array;

    public function getStorageName(): string;
}
