<?php

namespace App\Service;

use Dev\Tests\Patterns\Singleton\SingletonTrait;

class PDOMySQL extends \PDO
{

    use SingletonTrait;

    protected string $dbname = "php_advent_board";
    protected string $user = "root";
    protected string $pass = "";

    protected function __construct()
    {
        parent::__construct("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->pass);
    }



}
