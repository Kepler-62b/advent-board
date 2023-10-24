<?php

namespace Framework\Services\Database;

class LazyStorageDecorator implements StorageInterface
{
    private bool $connected = false;

    public function __construct(
        private StorageInterface $switchStorage,
    ) {
    }

    public function connect(): void
    {
        $this->switchStorage->connect();
    }

    public function lazyConnect(): void
    {
        if (!$this->connected) {
            $this->switchStorage->connect();
        }

        $this->connected = true;
    }

    public function get(string $id): ?array
    {
        $this->lazyConnect();

        return $this->switchStorage->get($id);
    }


}