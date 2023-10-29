<?php

namespace Framework\Services\Database;

class SwitchStorage implements StorageInterface
{
    private StorageInterface $activeStorage;

    /** @var StorageInterface[] */
    private array $storages = [];

    public function __construct(StorageInterface ...$storages)
    {
        $this->storages = $storages;
    }

    public function connect(): void
    {
        foreach ($this->storages as $storage) {
            try {

                /** @var SQLStorage|RedisStorage $storage */
                $storage->connect();

                $this->activeStorage = $storage;

                return;
            } catch (ConnectionException) {
                continue;
            }
        }
        throw new ConnectionException('SwitchStorage: All database die');
    }

    public function get(string $id): ?array
    {
        try {
            return $this->activeStorage->get($id);
        } catch (ConnectionException) {
            return $this->get($id);
        }
    }

    public function set(string $key, mixed $data): void
    {
        $this->activeStorage->set($key, $data);
    }

    public function getStorageName(): string
    {
        return $this->activeStorage->getStorageName();
    }
}
