<?php

namespace App\Repository;

use App\Database\DatabasePDO;
use App\Models\Image;

class ImageRepository
{


  /**
   * property for SQL statement
   */
  private $table = 'images_prod';
  private $limit = 5;


  public function __construct(
    private Image $model,
    private DatabasePDO $pdo
  ) {
  }

  public function getAllRows(int $page = 1): array
  {
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

  public function getOneRow(int $id): array
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

  public function saveRow(): bool
  {
    $connection = $this->pdo;
    $model = $this->model;
    $table = $this->table;

    $sql = "INSERT INTO $table (item, description, price, image)
            VALUES (?, ?, ?, ?)";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(1, $model->getName(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(3, $model->getItemId(), \PDO::PARAM_INT);
      $pdo_statment->execute();
      $insert_id = $connection->lastInsertId();
      print "Row added " . $insert_id;
      // $this->insert_id = $insert_id;
      return true;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }
  public function updateRow(): bool
  {
    $connection = $this->pdo;
    $model = $this->model;
    $table = $this->table;

    $sql = "UPDATE $table 
            SET item = :item, description = :description, price = :price, image = :image
            WHERE id = :id";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(':id', $model->getId(), \PDO::PARAM_INT);
      $pdo_statment->bindValue(':price', $model->getName(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(':image', $model->getItemId(), \PDO::PARAM_INT);
      $pdo_statment->execute();
      return true;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function getCountRows(): int
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "SELECT COUNT(*) FROM $table";

    $pdo_statment = $connection->query($sql);
    $result = $pdo_statment->fetch(\PDO::FETCH_NUM);
    return $result[0];
  }

  public function sortRows(string $sort = null, string $page = null, string $filter = null): array
  {
    $connection = $this->pdo;
    $table = $this->table;
    $limit = $this->limit;

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