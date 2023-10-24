<?php

namespace Framework\Services\Database;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LogDriverDecorator
{
    public function __construct(
        private DriverInterface $driver,
        private LoggerInterface $logger = new Logger('DatabaseConnection'),
    )
    {
    }

    public function connect(): void
    {
        $this->logger->pushHandler(new StreamHandler('/app/log/database.log'));
        try {
            $this->driver->connect();
            $this->logger->info('Connection successful');
        } catch (ConnectionException $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw new ConnectionException('PDOException / PDOSQLDriver connect error ' . $exception);
        }

    }
}
