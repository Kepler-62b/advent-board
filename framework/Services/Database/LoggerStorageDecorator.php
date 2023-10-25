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
            $this->logger->info('Storage connect');
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
            $this->logger->info('get data from', ['id' => $id, 'data' => $data]);
        } catch (ConnectionException $exception) {
            $this->logger->error($exception->getMessage(), ['id' => $id, 'exception' => $exception]);
            throw $exception;
        }

        return $data;
    }
}
