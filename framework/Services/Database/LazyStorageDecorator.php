<?php

namespace Framework\Services\Database;

class LazyStorageDecorator implements StorageInterface
{
    private bool $connected = false;

    public function __construct(
        private StorageInterface $storage,
    ) {
    }

    public function connect(): void
    {
        $this->storage->connect();
        $this->connected = true;
    }

    public function lazyConnect(): void
    {
        if (!$this->connected) {
            $this->storage->connect();
        }
        $this->connected = true;
    }

    public function get(string $id): ?array
    {
        $this->lazyConnect();

        return $this->storage->get($id);
    }
}
