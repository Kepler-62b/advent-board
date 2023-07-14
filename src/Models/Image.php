<?php

namespace App\Models;

class Image extends Advent
{

  // property for SQL queries
  protected $table = 'images_dev';

  public function pdoGetRow($id)
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "SELECT name FROM $table WHERE item_id = :id";

    $pdo_statement = $connection->prepare($sql);

    try {
      $pdo_statement->bindValue(":id", $id, \PDO::PARAM_INT);
      $pdo_statement->execute();
      $result = $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function test() {
    var_dump($this->pdo);
   
  }
}
