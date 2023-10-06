<?php

namespace App\Service;

use App\Service\SingletonTrait;

// @TODO подумать над универсальной оберткой для наследования от нее всех подключений
class PHPAdventBoardDatabase extends \PDO
{

    use SingletonTrait;

    // @TODO принимать параметры подключения из файла
    protected string $dsn = "mysql:host=adverts-mysql;dbname=adverts-board";
    protected string $user = "root";
    protected string $pass = "";

    protected function __construct()
    {
        parent::__construct($this->dsn, $this->user, $this->pass);
//        var_dump(debug_backtrace());
    }


}
