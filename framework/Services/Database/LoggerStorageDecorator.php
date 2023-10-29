<?php

namespace Framework\Services\Database;

use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

final class LoggerStorageDecorator implements StorageInterface
{
    public function __construct(
        private StorageInterface $storage,
        private LoggerInterface $logger,
    ) {
    }

    public function connect(): void
    {
        $this->logger->pushHandler(new StreamHandler('/app/log/database_connect.log'));
        try {
            $this->storage->connect();
            $this->logger->info($this->storage::class .' connect');
        } catch (ConnectionException $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw $exception;
        }
    }

    public function get(string $id): ?array
    {
        $this->logger->pushHandler(new StreamHandler('/app/log/database_get_data.log'));

        try {
            $data = $this->storage->get($id);
            $this->logger->info($this->storage->getStorageName() .' get', ['id' => $id, 'data' => $data]);
        } catch (ConnectionException $exception) {
            $this->logger->error($exception->getMessage(), ['id' => $id, 'exception' => $exception]);
            throw $exception;
        }

        return $data;
    }

    public function set(string $key, mixed $data): void
    {
        $this->logger->pushHandler(new StreamHandler('/app/log/database_set_data.log'));

        try {
            $data = $this->storage->set($key, $data);
            $this->logger->info('get data from ' .$this->storage->getStorageName(), ['id' => $key, 'data' => $data]);
        } catch (ConnectionException $exception) {
            $this->logger->error($exception->getMessage(), ['id' => $key, 'exception' => $exception]);
            throw $exception;
        }
    }

    public function getStorageName(): string
    {
        return $this->storage->getStorageName();
    }
}
