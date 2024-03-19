<?php

namespace Tests\Unit;

use App\Models\Image;
use Framework\Services\Database\DatabaseConfigs;
use Framework\Services\Database\RedisDriver;
use Framework\Services\DependencyContainer;
use League\Container\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

class DependencyContainerTest extends TestCase
{
    private array $services = [];
    private DependencyContainer $container;

    protected function setUp(): void
    {
        $this->services = [
            'container' => [
                DatabaseConfigs::class => fn(): DatabaseConfigs => new DatabaseConfigs(),
                RedisDriver::class => fn(DependencyContainer $c): RedisDriver => new RedisDriver(...$c->get(DatabaseConfigs::class)->setConfig('Redis')),
                Image::class => fn(): Image => new Image('container image', 0),
            ],
        ];
        $this->container = new DependencyContainer($this->services['container']);
    }


    public static function toGetInstance(): array
    {
        return [
            'DatabaseConfigInstance' => ['className' => DatabaseConfigs::class, 'instanceExpected' => DatabaseConfigs::class],
            'RedisDriverInstance' => ['className' => RedisDriver::class, 'instanceExpected' => RedisDriver::class],
        ];
    }

    public static function toExceptionFromContainer(): array
    {
        return [
            'NotFoundException' => ['className' => \StdClass::class, 'exceptionType' => NotFoundException::class],
        ];
    }

    public static function toEqualInstance(): array
    {
        return [
            'ImageInstance' => ['firstInstance' => Image::class, 'secondInstance' => Image::class],
        ];

    }

    /** @dataProvider toGetInstance */
    public function testGetInstance(string $className, string $instanceExpected): void
    {
        $container = $this->container;
        $instanceContainer = $container->get($className);
        $this->assertInstanceOf($instanceExpected, $instanceContainer);
    }

    /** @dataProvider toExceptionFromContainer */
    public function testExceptionFromContainer(string $className, string $exceptionType): void
    {
        $container = $this->container;
        $this->expectException($exceptionType);
        $container->get($className);
    }

    /** @dataProvider toEqualInstance */
    public function testEqualInstance(string $firstInstance, string $secondInstance): void
    {
        $firstInstance = $this->container->get($firstInstance);
        $firstInstance->setItemId(100);
        $secondInstance = $this->container->get($secondInstance);

        $this->assertEquals($firstInstance, $secondInstance);
    }
}
