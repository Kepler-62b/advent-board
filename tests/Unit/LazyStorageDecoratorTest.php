<?php

namespace Test\Unit;

use Framework\Services\Database\ConnectionException;
use Framework\Services\Database\DriverInterface;
use Framework\Services\Database\PDOSQLDriver;
use Framework\Services\Database\StorageInterface;
use Framework\Services\Database\LazyStorageDecorator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LazyStorageDecoratorTest extends TestCase
{

    private MockObject $pdo;
    private MockObject $driver;
    private MockObject $storage;
    private LazyStorageDecorator $decorator;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(\PDO::class);
        $this->driver = $this->createMock(DriverInterface::class);
        $this->storage = $this->createMock(StorageInterface::class);

        $this->decorator = new LazyStorageDecorator($this->storage);
    }

    public function testConnectException()
    {
//        $config = [
//            'pgsql:host=postgres;port=5432;dbname=adverts-board',
//            'postgres',
//            'secret',
//        ];
//        $pdo = $this->createMock(\PDO::class);
//        $this->assertInstanceOf(\PDO::class, $pdo);

        $decorator = $this->createMock(LazyStorageDecorator::class);
//        $this->assertInstanceOf(LazyStorageDecorator::class, $decorator);



        $decorator->expects($this->once())
        ->method('connect');

        $decorator->lazyConnect();
//        $decorator->connect();



//        $this->expectException(ConnectionException::class);
//
//        $this->storage->method('connect')
//            ->will($this->throwException(new ConnectionException()));
//
//
//        $this->storage->connect();


//        $driver = new PDOSQLDriver(...$config);
//        $this->expectException(ConnectionException::class);
//        $driver->connect();


    }


}
