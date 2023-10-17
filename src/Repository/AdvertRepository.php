<?php

namespace App\Repository;

use App\Models\Advert;
use Framework\Services\HydratorService;
use Framework\Services\NoDBConnectionException;
use Framework\Services\Relation;

class AdvertRepository
{
    private \PDO $pdo;
    private string $table = 'adverts';
    private ?int $lastInsertId;

    /** @var int задает количество извлекаемых строк из таблицы */
    public const SELECT_LIMIT = 10;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCount(): int
    {
        $connection = $this->pdo;
        $table = $this->table;

        $sql = "SELECT COUNT(*) FROM $table";

        $pdo_statment = $connection->query($sql);
        [$count] = $pdo_statment->fetch(\PDO::FETCH_NUM);
        return $count;
    }

    /**
     * @param int $page
     * @return Advert[]
     * @throws \ReflectionException
     */
    public function fetchAll(int $page = 1): array
    {
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
            $modelsStorage = [];
            foreach ($result as $data) {
                $model = $hydrator->hydrate(
                    Advert::class,
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
                $relationModel = (new Relation($model))->getRelation('id');
                $modelsStorage[] = $relationModel;
            }
            return $modelsStorage;

        } catch (\PDOException $exception) {
//            throw new \PDOException($exception);
            throw new NoDBConnectionException("No database connection / $exception");
        }

    }

    /**
     * @return ?Advert[]
     * @throws \PDOException|\ReflectionException
     */

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

        $sql =
            "UPDATE $table SET item = :item, description = :description, price = :price, image = :image WHERE id = :id";

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

    public function getMax(int $page, string $filter): array
    {
        $connection = $this->pdo;
        $table = $this->table;
        $limit = self::SELECT_LIMIT;

        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM $table ORDER BY $filter DESC LIMIT $limit OFFSET :offset";

        try {
            $pdo_statement = $connection->prepare($sql);
            $pdo_statement->bindValue(":offset", $offset, \PDO::PARAM_INT);
            $pdo_statement->execute();

            $result = $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);

            $hydrator = new HydratorService();
            $modelsStorage = [];
            foreach ($result as $data) {
                $modelsStorage[] = $hydrator->hydrate(
                    Advert::class,
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
            throw new \PDOException($exception);
        }
    }

    public function getMin(int $page, string $filter): array
    {
        $connection = $this->pdo;
        $table = $this->table;
        $limit = self::SELECT_LIMIT;

        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM $table ORDER BY $filter ASC LIMIT $limit OFFSET :offset";
        try {
            $pdo_statement = $connection->prepare($sql);
            $pdo_statement->bindValue(":offset", $offset, \PDO::PARAM_INT);
            $pdo_statement->execute();

            $result = $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);

            $hydrator = new HydratorService();
            $modelsStorage = [];
            foreach ($result as $data) {
                $modelsStorage[] = $hydrator->hydrate(
                    Advert::class,
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
            throw new \PDOException($exception);
        }
    }
}