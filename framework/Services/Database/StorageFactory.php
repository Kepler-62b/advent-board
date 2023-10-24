<?php

namespace Framework\Services\Database;

use Framework\Services\Database\PDOSQLDriver;
use Framework\Services\Database\RedisDriver;
use Framework\Services\Database\SQLStorage;
use Framework\Services\Database\RedisStorage;
use Framework\Services\Database\SwitchStorage;
use Framework\Services\Database\LazyStorageDecorator;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class StorageFactory
{

    public function __construct(
        private PDOSQLDriver    $PDOSQLDriver,
        private RedisDriver     $redisDriver,
        private LoggerInterface $logger = new Logger('LoggerStorageDecorator'),
    )
    {
    }

    public function create(): StorageInterface
    {
        return new LoggerStorageDecorator(
            (new LazyStorageDecorator(
                (new SwitchStorage(
                    new SQLStorage($this->PDOSQLDriver),
                    new RedisStorage($this->redisDriver),
                )))), $this->logger);
    }


}