<?php

namespace Framework\Services\Database;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerDriverDecorator implements DriverInterface
{
    public function __construct(
        private DriverInterface $driver,
        private LoggerInterface $logger = new Logger('LoggerDriverDecorator'),
    ) {
    }

    public function connect(): void
    {
        $this->logger->pushHandler(new StreamHandler('/app/log/database_connect.log'));
        $this->logger->info($this->getDriverName().'  connect');
        try {
            $this->driver->connect();
        } catch (DriverException $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw new DriverException('LoggerDriverDecorator connect error '.$exception);
        }
    }

    public function get(QueryBuilderInterface $queryBuilder): array
    {
        $this->logger->pushHandler(new StreamHandler('/app/log/database_get_data.log'));
        $this->logger->info($this->getDriverName().'  get', ['data' => $queryBuilder->get()]);

        return $this->driver->get($queryBuilder);
    }

    public function set(QueryBuilderInterface $queryBuilder): void
    {
        $this->driver->set($queryBuilder);
    }

    public function getDriverName(): string
    {
        return $this->driver->getDriverName();
    }
}
