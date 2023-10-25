<?php

namespace Framework\Services\Database;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class StorageFactory
{
    public function __construct(
        private PDOSQLDriver $PDOSQLDriver,
        private RedisDriver $redisDriver,
        private LoggerInterface $logger = new Logger('LoggerStorageDecorator'),
    ) {
    }

    public function create(): StorageInterface
    {
        return new LoggerStorageDecorator(
            new LazyStorageDecorator(
                new SwitchStorage(
                    new SQLStorage(new LoggerDriverDecorator($this->PDOSQLDriver)),
                    new RedisStorage(new LoggerDriverDecorator($this->redisDriver)),
                )), $this->logger);
    }
}
