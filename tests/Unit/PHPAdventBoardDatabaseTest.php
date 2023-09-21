<?php

namespace Tests\Unit;

use App\Service\PHPAdventBoardDatabase;
use PHPUnit\Framework\TestCase;

class PHPAdventBoardDatabaseTest extends TestCase
{

    private PHPAdventBoardDatabase $databaseConnection;

    protected function setUp(): void
    {
        $this->databaseConnection = PHPAdventBoardDatabase::getInstance();
    }

    public function testGetPDOConnection(): void
    {
        $result = $this->databaseConnection;
        $this->assertInstanceOf(PHPAdventBoardDatabase::class, $result);
    }

}
