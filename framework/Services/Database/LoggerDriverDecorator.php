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
        $this->logger->info($this->getDriverName().' driver connect');
        try {
            $this->driver->connect();
        } catch (ConnectionException $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw new ConnectionException('PDOException / PDOSQLDriver connect error '.$exception);
        }
    }

    public function get(string $sql, array $params = null)
    {
        return $this->driver->get($sql, $params);
    }

    public function getDriverName(): string
    {
        return $this->driver->getDriverName();
    }
}
