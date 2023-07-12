<?php

class PDOLocal
{

  private $pdo;

  public function __construct(string $dbname)
  {
    try {
      $connection_PDO = new PDO("mysql:host=localhost;dbname=$dbname", 'root', '');
      $this->pdo = $connection_PDO;
    } catch (PDOException $exception) {
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

  public function pdoGetRows($page = 1, $limit = 20)
  {
    $connection = $this->pdo;

    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM advents LIMIT :limit OFFSET :offset";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(":limit", $limit, PDO::PARAM_INT);
      $pdo_statment->bindValue(":offset", $offset, PDO::PARAM_INT);

      $pdo_statment->execute();

      $result = $pdo_statment->fetchAll(PDO::FETCH_ASSOC);

      return $result;
    } catch (PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function pdoGetRow($id)
  {
    $connection = $this->pdo;
    $sql = "SELECT * FROM advents WHERE id=?";
    $pdo_statment = $connection->prepare($sql);
    try {
      $pdo_statment->execute(array($id));
      $result = $pdo_statment->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function pdoCreateRow($item, $description, $price, $image)
  {
    $connection = $this->pdo;

    $sql = "INSERT INTO advents (item, description, price, image)
            VALUES (?, ?, ?, ?)";

    $pdo_statment = $connection->prepare($sql);

    try {
      $pdo_statment->bindValue(1, $item, PDO::PARAM_STR);
      $pdo_statment->bindValue(2, $description, PDO::PARAM_STR);
      $pdo_statment->bindValue(3, $price, PDO::PARAM_INT);
      $pdo_statment->bindValue(4, $image, PDO::PARAM_STR);
      $pdo_statment->execute();
      print "Row " . $connection->lastInsertId() . " added";
    } catch (PDOException $exception) {
      die('Ошибка: ' . $exception->getMessage());
    }
  }

  public function pdoCountRows()
  {

    $connection = $this->pdo;

    $sql = "SELECT COUNT(*) FROM advents";

    $pdo_statment = $connection->query($sql);
    $result = $pdo_statment->fetch(PDO::FETCH_NUM);
    return $result[0];
  }

  public function pdoSortRow($sort, $page, $limit = 20)
  {
    $connection = $this->pdo;

    $offset = ($page - 1) * $limit;

    if ($sort === 'min') {
      $sql = "SELECT * FROM advents ORDER BY price ASC LIMIT :limit OFFSET :offset";
    } elseif ($sort === 'max') {
      $sql = "SELECT * FROM advents ORDER BY price DESC LIMIT :limit OFFSET :offset";
    } elseif ($sort === 'def') {
      $sql = "SELECT * FROM advents LIMIT :limit OFFSET :offset";
    }

    $pdo_statment = $connection->prepare($sql);

    $pdo_statment->bindValue(":limit", $limit, PDO::PARAM_INT);
    $pdo_statment->bindValue(":offset", $offset, PDO::PARAM_INT);
    $pdo_statment->execute();

    $result = $pdo_statment->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }


}
