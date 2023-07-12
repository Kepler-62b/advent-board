<?php

function openPdoMysql(string $dbname)
{
  try {
    $connection_PDO = new PDO("mysql:host=localhost;dbname=$dbname", 'root', '');
    return $connection_PDO;
  } catch (PDOException $exception) {
    die('Подключение не удалось: ' . $exception->getMessage());
  }
}

function closePdoMysql()
{
  return $connection_PDO = null;
}

function pdoGetRows()
{
  $connection = openPdoMysql('php_advent_board');

  $sql = "SELECT * from advents";

  try {
    $pdo_statment = $connection->query($sql);
    $result = $pdo_statment->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  } catch (PDOException $exception) {
    die('Ошибка: ' . $exception->getMessage());
  }
}

function pdoGetRow(int $id)
{
  $connect = openPdoMysql('php_advent_board');

  $sql = 'SELECT * FROM advents WHERE id=:id';

  $prepare = $connect->prepare($sql);
  $prepare->bindValue(':id', $id, PDO::PARAM_INT);
  $prepare->execute();

  $result = $prepare->fetchAll(PDO::FETCH_ASSOC);

  return $result;
}

function pdoCreateRow($item, $description, $price, $image)
{
  $connection = openPdoMysql('php_advent_board');

  $sql = 'INSERT INTO advents (item, description, price, image) 
          VALUES (?, ?, ?, ?)';

  $prepare = $connection->prepare($sql);

  try {
    $prepare->execute(array($item, $description, $price, $image));
    return true;
  } catch (PDOException $exception) {
    die('Error: ' . $exception->getMessage());
  }
}

function pdoGetPagination($page)
{
  $connection = openPdoMysql('php_advent_board');

  $limit = 10;
  $offset = ($page - 1) * $limit;

  $sql = "SELECT * FROM advents LIMIT :limit OFFSET :offset";

  $statment = $connection->prepare($sql);

  $statment->bindParam('limit', $limit, PDO::PARAM_INT);
  $statment->bindParam('offset', $offset, PDO::PARAM_INT);
  $statment->execute();

  $result = $statment->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function test() {
  $connection = openPdoMysql('php_advent_board');
  // var_dump($connection);
  $sql = "SELECT COUNT(*) FROM advents";
  $pdo_statment = $connection->query($sql);
  // var_dump($pdo_statment);
  $result = $pdo_statment->fetchAll(PDO::FETCH_ASSOC);
  // var_dump($result);
  return $result;
}

