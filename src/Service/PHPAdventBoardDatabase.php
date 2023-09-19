<?php

namespace App\Service;

use Dev\Tests\Patterns\Singleton\SingletonTrait;

// @TODO подумать над универсальной оберткой для наследования от нее всех подключений
class PHPAdventBoardDatabase extends \PDO
{

    use SingletonTrait;

    // @TODO принимать параметры подключения из файла
    protected string $dbname = "php_advent_board";
    protected string $user = "root";
    protected string $pass = "";

    protected function __construct()
    {
        parent::__construct("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->pass);
    }


}
