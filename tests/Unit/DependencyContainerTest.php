<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Repository\ImageRepository;
use App\Service\DependencyContainer;
use App\Service\MySQLAdvertsBoard;
use PHPUnit\Framework\TestCase;

class DependencyContainerTest extends TestCase
{
    private DependencyContainer $container;

    protected function setUp(): void
    {
        $this->container = new DependencyContainer();
    }

    public static function toPositiveTesting(): array
    {
        return [
            'RepositoryInstance' => ['className' => Image::class, 'instanceExpected' => ImageRepository::class],
            'PDOConnectionInstance' => ['className' => MySQLAdvertsBoard::class, 'instanceExpected' => MySQLAdvertsBoard::class],
        ];
    }

    public static function toNegativeTesting(): array
    {
        return [
            'ClassNotContainsException' => ['className' => \StdClass::class, 'exceptionType' => \Exception::class],
        ];
    }

    /** @dataProvider toPositiveTesting */
    public function testGetInstanceFromContainer(string $className, string $instanceExpected): void
    {
        $container = $this->container;
        $instanceContainer = $container->get($className);
        $this->assertInstanceOf($instanceExpected, $instanceContainer);
    }

    /** @dataProvider toNegativeTesting */
    public function testExceptionFromContainer(string $className, string $exceptionType): void
    {
        $container = $this->container;
        $this->expectException($exceptionType);
        $container->get($className);
    }
}
