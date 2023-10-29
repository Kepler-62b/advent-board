<?php

namespace Framework\Services\Database;

class LazyStorageDecorator implements StorageInterface
{
    private bool $connected = false;

    public function __construct(
        private StorageInterface $storage,
    )
    {
    }

    public function connect(): void
    {
//        try {
//            $this->storage->connect();
//            $this->connected = true;
//        } catch (ConnectionException $exception) {
//            throw new ConnectionException($exception);
//        }
    }

    public function lazyConnect(): void
    {
        if (!$this->connected) {
            $this->storage->connect();
            $this->connected = true;
        }
    }

    public function get(string $id): ?array
    {
        $this->lazyConnect();

        return $this->storage->get($id);
    }

    public function set(string $key, mixed $data): void
    {
        $this->lazyConnect();

        $this->storage->set($key, $data);
    }

    public function getStorageName(): string
    {
        return $this->storage->getStorageName();
    }
}
