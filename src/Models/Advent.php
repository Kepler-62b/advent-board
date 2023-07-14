<?php

namespace App\Models;

class Advent
{

  protected $pdo;
  public $insert_id;

  // property for pdo connection
  protected $dbname = "php_advent_board";
  protected $user = "root";
  protected $pass = "";

  // property for SQL queries
  protected $table = 'advents_prod';
  protected $limit = 5; // может сделать константой?


  public function __construct()
  {
    try {
      $connection_PDO = new \PDO("mysql:host=localhost;dbname=$this->dbname", $this->user, $this->pass);
      $this->pdo = $connection_PDO;
    } catch (\PDOException $exception) {
      die('Error: ' . $exception->getMessage());
    }
  }

  public function pdoGetConnection()
  {
    return $this->pdo;
  }

  public function pdoCloseConnection()
  {
    $this->pdo = null;
  }


  public function pdoGetRows($page = 1)
  {
    // может оформить возврат всех постоянно вызывающихся свойств через геттер?
    $connection = $this->pdo;
    $table = $this->table;
    $limit = $this->limit;

    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM $table LIMIT $limit OFFSET :offset";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(":offset", $offset, \PDO::PARAM_INT);

      $pdo_statment->execute();

      $result = $pdo_statment->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function pdoGetRow($id)
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "SELECT * FROM $table WHERE id = :id";

    $pdo_statement = $connection->prepare($sql);

    try {
      $pdo_statement->bindValue("id", $id, \PDO::PARAM_INT);
      $pdo_statement->execute();
      $result = $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function pdoCreateRow($item, $description, $price, $image)
  {
    $connection = $this->pdo;
    $table = $this->table;


    $sql = "INSERT INTO $table (item, description, price, image)
            VALUES (?, ?, ?, ?)";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(1, $item, \PDO::PARAM_STR);
      $pdo_statment->bindValue(2, $description, \PDO::PARAM_STR);
      $pdo_statment->bindValue(3, $price, \PDO::PARAM_INT);
      $pdo_statment->bindValue(4, $image, \PDO::PARAM_STR);
      $pdo_statment->execute();
      $insert_id = $connection->lastInsertId();
      print "Row " . $insert_id . " added";
      $this->insert_id = $insert_id;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }
  // протестировать метод
  public function pdoUpdateRows($id, $item, $description, $price, $image)
  {
    $connection = $this->pdo;
    $table = $this->table;


    $sql = "UPDATE $table 
            SET item = :item, description = :description, price = :price, image = :image
            WHERE id = :id";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(':id', $id, \PDO::PARAM_INT);
      $pdo_statment->bindValue(':item', $item, \PDO::PARAM_STR);
      $pdo_statment->bindValue(':description', $description, \PDO::PARAM_STR);
      $pdo_statment->bindValue(':price', $price, \PDO::PARAM_INT);
      $pdo_statment->bindValue(':image', $image, \PDO::PARAM_STR);
      $pdo_statment->execute();
      // $insert_id = $connection->lastInsertId();
      // $this->insert_id = $insert_id;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function pdoUpdateRow($id, $image)
  {
    $connection = $this->pdo;
    $table = $this->table;


    $sql = "UPDATE $table 
            SET image = :image WHERE id = :id";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(':id', $id, \PDO::PARAM_INT);
      $pdo_statment->bindValue(':image', $image, \PDO::PARAM_STR);
      $pdo_statment->execute();
      print "Image added";
      // $insert_id = $connection->lastInsertId();
      // $this->insert_id = $insert_id;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function pdoCountRows()
  {

    $connection = $this->pdo;
    $table = $this->table;

    $sql = "SELECT COUNT(*) FROM $table";

    $pdo_statment = $connection->query($sql);
    $result = $pdo_statment->fetch(\PDO::FETCH_NUM);
    return $result[0];
  }

  public function pdoSortRow($sort, $page, $filter)
  {
    $connection = $this->pdo;
    $table = $this->table;
    $limit = $this->limit;

    $offset = ($page - 1) * $limit;

    if ($filter === NULL) {
      $sql = "SELECT * FROM $table LIMIT $limit OFFSET :offset";
    } elseif ($sort === 'min') {
      $sql = "SELECT * FROM $table ORDER BY $filter ASC LIMIT $limit OFFSET :offset";
    } elseif ($sort === 'max') {
      $sql = "SELECT * FROM $table ORDER BY $filter DESC LIMIT $limit OFFSET :offset";
    } elseif ($sort === 'def') {
      $sql = "SELECT * FROM $table LIMIT $limit OFFSET :offset";
    }

    $pdo_statment = $connection->prepare($sql);

    $pdo_statment->bindValue(":offset", $offset, \PDO::PARAM_INT);
    $pdo_statment->execute();

    $result = $pdo_statment->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }
}
