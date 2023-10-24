<?php

namespace Framework\Services\Database;


use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;


final class LoggerStorageDecorator implements StorageInterface
{
    public function __construct(
        private StorageInterface $storage,
        private LoggerInterface  $logger,
    )
    {
    }

    public function connect(): void
    {
        $this->logger->pushHandler(new StreamHandler('/app/log/database.log'));
        try {
            $this->storage->connect();
            $this->logger->info('connect');
        } catch (ConnectionException $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    public function get(string $id): ?array
    {
        $this->connect();

        try {
            $data = $this->storage->get($id);
            $this->logger->info('get data from', ['id' => $id, 'data' => $data]);
        } catch (ConnectionException $e) {
            $this->logger->error($e->getMessage(), ['id' => $id, 'exception' => $e]);
            throw $e;
        }

        return $data;
    }

}