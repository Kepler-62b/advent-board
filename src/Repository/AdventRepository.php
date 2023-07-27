<?php

namespace App\Repository;

use App\Service\DatabasePDO;
use App\Models\Advent;

class AdventRepository
{

  /**
   * property for SQL statement
   */
  private $table = 'advents_prod';
  public const LIMIT = 5;


  public function __construct(
    private DatabasePDO $pdo
  ) {
  }

  public function getAllRows(int $page = 1): array
  {
    $connection = $this->pdo;
    $table = $this->table;
    $limit = self::LIMIT;

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

  public function findById(int $id): array
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

  public function saveRow(Advent $advent): bool
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "INSERT INTO $table (item, description, price, image)
            VALUES (?, ?, ?, ?)";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(1, $advent->getItem(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(2, $advent->getDescription(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(3, $advent->getPrice(), \PDO::PARAM_INT);
      $pdo_statment->bindValue(4, $advent->getImage(), \PDO::PARAM_STR);
      $pdo_statment->execute();
      $insert_id = $connection->lastInsertId();
      print "Row added " . $insert_id;
      // $this->insert_id = $insert_id;
      return true;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }
  public function updateRow(Advent $advent): bool
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "UPDATE $table 
            SET item = :item, description = :description, price = :price, image = :image
            WHERE id = :id";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(':id', $advent->getId(), \PDO::PARAM_INT);
      $pdo_statment->bindValue(':item', $advent->getItem(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(':description', $advent->getPrice(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(':price', $advent->getPrice(), \PDO::PARAM_INT);
      $pdo_statment->bindValue(':image', $advent->getImage(), \PDO::PARAM_STR);
      $pdo_statment->execute();
      return true;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function updateAttribute(Advent $advent, string $property, int $value)
  {
    $connection = $this->pdo;
    $table = $this->table;
    var_dump($advent);

    var_dump(property_exists($advent, $property));

    // var_dump($value);



    // var_dump($advent->setPrice(3000));

    // $sql = "UPDATE $table 
    //         SET image = :image WHERE id = :id";

    // $pdo_statment = $connection->prepare($sql);

    // try {
    //   $pdo_statment->bindValue(':id', $advent->getId(), \PDO::PARAM_INT);
    //   $pdo_statment->bindValue(':image', $image, \PDO::PARAM_STR);
    //   $pdo_statment->execute();
    //   print "Image added";
    //   // $insert_id = $connection->lastInsertId();
    //   // $this->insert_id = $insert_id;
    // } catch (\PDOException $exception) {
    //   die('Ошибка: ' . $exception->getMessage());
    // }
  }

  public function getCountRows(): int
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "SELECT COUNT(*) FROM $table";

    $pdo_statment = $connection->query($sql);
    $result = $pdo_statment->fetch(\PDO::FETCH_NUM);
    $count = ceil($result[0] / self::LIMIT);
    return $count;
  }

  public function getMax(int $page, string $filter): array
  {
    $connection = $this->pdo;
    $table = $this->table;
    $limit = self::LIMIT;

    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM $table ORDER BY $filter DESC LIMIT $limit OFFSET :offset";
    $pdo_statment = $connection->prepare($sql);
    $pdo_statment->bindValue(":offset", $offset, \PDO::PARAM_INT);
    $pdo_statment->execute();
    $result = $pdo_statment->fetchAll(\PDO::FETCH_ASSOC);
    return $result;

  }

  public function getMin(int $page, string $filter): array
  {
    $connection = $this->pdo;
    $table = $this->table;
    $limit = self::LIMIT;

    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM $table ORDER BY $filter ASC LIMIT $limit OFFSET :offset";
    $pdo_statment = $connection->prepare($sql);
    $pdo_statment->bindValue(":offset", $offset, \PDO::PARAM_INT);
    $pdo_statment->execute();
    $result = $pdo_statment->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  public function sortRows(string $sort = null, string $page = null, string $filter = null): array
  {
    $connection = $this->pdo;
    $table = $this->table;
    $limit = self::LIMIT;

    $offset = ($page - 1) * $limit;

    if ($filter === NULL) {
      $sql = "SELECT * FROM $table LIMIT $limit OFFSET :offset";
      // var_dump($sql);
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