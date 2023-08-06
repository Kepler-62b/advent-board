<?php

namespace App\Service;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


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
    parent::__construct("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->pass);
  }

}