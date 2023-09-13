<?php

namespace App\Repository;

use App\Service\DatabasePDO;
use App\Service\HydratorService;

use App\Models\Advent;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AdventRepository
{
  private DatabasePDO $pdo;
  private string $table = 'advents_prod';
  private ?int $lastInsertId;
  public const SELECT_LIMIT = 5;

  public function __construct(DatabasePDO $pdo)
  {
    $this->pdo = $pdo;
  }

  /**
   * @return Advent[]
   */
  public function fetchAll(int $page = 1): array
  {
    $logger = (new Logger(AdventRepository::class))->pushHandler(new StreamHandler('dev/Logger/log/dev.log', Logger::DEBUG));

    $connection = $this->pdo;
    $table = $this->table;
    $limit = self::SELECT_LIMIT;

    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM $table LIMIT $limit OFFSET :offset";

    try {
      $pdo_statement = $connection->prepare($sql);
      $pdo_statement->bindValue(":offset", $offset, \PDO::PARAM_INT);
      $pdo_statement->execute();

      $result = $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);

      $hydrator = new HydratorService();

      foreach ($result as $data) {
        $modelsStorage[] = $hydrator->hydrate(
          Advent::class,
          $data,
          [
            'id' => 'id',
            'item' => 'item',
            'description' => 'description',
            'price' => 'price',
            'image' => 'image',
            'created_date' => 'createdDate',
            'modified_date' => 'modifiedDate',
          ]
        );
      }

      return $modelsStorage;

    } catch (\PDOException $exception) {
      $logger->critical('Error:', ['exception' => $exception]);
      throw new \PDOException($exception);
    }
  }

  /**
   * @return Advent[]
   */
  public function findById(int $id): ?array
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "SELECT * FROM $table WHERE id = :id";

    $pdo_statement = $connection->prepare($sql);

    try {
      $pdo_statement->bindValue("id", $id, \PDO::PARAM_INT);
      $pdo_statement->execute();

      if ($result = $pdo_statement->fetch(\PDO::FETCH_ASSOC)) {

        $hydrator = new HydratorService();

        $model[] = $hydrator->hydrate(
          Advent::class,
          $result,
          [
            'id' => 'id',
            'item' => 'item',
            'description' => 'description',
            'price' => 'price',
            'image' => 'image',
            'created_date' => 'createdDate',
            'modified_date' => 'modifiedDate',
          ]
        );
        return $model;
      } else {
        return NULL;
      }
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function save(object $model): bool
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "INSERT INTO $table (item, description, price, image)
            VALUES (?, ?, ?, ?)";

    try {
      $pdo_statment = $connection->prepare($sql);
      $pdo_statment->bindValue(1, $model->getItem(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(2, $model->getDescription(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(3, $model->getPrice(), \PDO::PARAM_INT);
      $pdo_statment->bindValue(4, $model->getImage(), \PDO::PARAM_STR);
      $pdo_statment->execute();
      $lastInsertId = $connection->lastInsertId();
      $this->lastInsertId = $lastInsertId;
      // print "Row added " . $insert_id;
      return true;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function update(object $model): bool
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "UPDATE $table 
            SET item = :item, description = :description, price = :price, image = :image
            WHERE id = :id";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(':id', $model->getId(), \PDO::PARAM_INT);
      $pdo_statment->bindValue(':item', $model->getItem(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(':description', $model->getDescription(), \PDO::PARAM_STR);
      $pdo_statment->bindValue(':price', $model->getPrice(), \PDO::PARAM_INT);
      $pdo_statment->bindValue(':image', $model->getImage(), \PDO::PARAM_STR);
      $pdo_statment->execute();
      return true;
    } catch (\PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function getCount(): int
  {
    $connection = $this->pdo;
    $table = $this->table;

    $sql = "SELECT COUNT(*) FROM $table";

    $pdo_statment = $connection->query($sql);
    $count = $pdo_statment->fetch(\PDO::FETCH_NUM);
    return $count[0];
  }

  public function getMax(int $page, string $filter): array
  {
    $connection = $this->pdo;
    $table = $this->table;
    $limit = self::SELECT_LIMIT;

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
    $limit = self::SELECT_LIMIT;

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
    $limit = self::SELECT_LIMIT;

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