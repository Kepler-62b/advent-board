<?php

namespace App\Database;

class DatabasePDO extends \PDO
{
  /**
   *  property for connection
   */
  protected $dbname = "php_advent_board";
  protected $user = "root";
  protected $pass = "";

  public function __construct()
  {
    try {
      parent::__construct("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->pass);
    } catch (\PDOException $exception) {
      die('Error: ' . $exception->getMessage());
    }
  }

}
