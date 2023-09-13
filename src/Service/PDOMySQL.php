<?php

namespace App\Service;

class PDOMySQL extends \PDO
{
    protected string $dbname = "php_advent_board";
    protected string $user = "root";
    protected string $pass = "";

    public function __construct()
    {
        parent::__construct("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->pass);
    }
}
