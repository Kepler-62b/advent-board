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

                $storage->connect();

                $this->activeStorage = $storage;

                return;
            } catch (ConnectionException) {
                continue;
            }
        }
        throw new \Exception('Connection error');
    }

    public function get(string $id): ?array
    {
        $this->connect();

        try {
            return $this->activeStorage->get($id);
        } catch (ConnectionException){
            return $this->get($id);
        }

    }
}
