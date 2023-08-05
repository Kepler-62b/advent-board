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
    $monologLogger = new Logger(DatabasePDO::class);
    $monologLogger->pushHandler(new StreamHandler('dev/Logger/log/dev.log', Logger::DEBUG));

    try {
      parent::__construct("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->pass);
      $monologLogger->debug(
        'Connecting with parameters:',
        [
          'dbname' => $this->dbname,
          'user' => $this->user,
          'pass' => $this->pass,
        ]
      );
    } catch (\PDOException $exception) {
      $monologLogger->critical('Error:', [
        'exception' => $exception,
      ]);
    }
  }

}