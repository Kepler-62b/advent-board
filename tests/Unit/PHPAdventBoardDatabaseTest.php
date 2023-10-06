<?php

namespace Tests\Unit;

use App\Service\MySQLAdvertsBoard;
use PHPUnit\Framework\TestCase;

class PHPAdventBoardDatabaseTest extends TestCase
{

    private MySQLAdvertsBoard $databaseConnection;

    protected function setUp(): void
    {
        $this->databaseConnection = MySQLAdvertsBoard::getInstance();
    }

    public function testGetPDOConnection(): void
    {
        $result = $this->databaseConnection;
        $this->assertInstanceOf(MySQLAdvertsBoard::class, $result);
    }

}
