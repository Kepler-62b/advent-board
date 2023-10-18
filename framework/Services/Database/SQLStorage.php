<?php

namespace Framework\Services\Database;

use App\Models\Advert;
use Framework\Services\HydratorService;
use Framework\Services\NoDBConnectionException;
use Framework\Services\Relation;

class SQLStorage implements StorageInterface
{

    use SQLQueryTrait;

    private \PDO $pdo;

    private $table = 'adverts';
    private const SELECT_LIMIT = 10;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function pdoStatementHandler(string $sql)
    {
        $pdoStmt = $this->pdo->prepare($sql);
        // @TODO логика связывания параметров запроса

        $pdoStmt->execute();
        $data = $pdoStmt->fetch(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function selectById(int $id): array
    {
        $sql = $this->select('*', $this->table)
            ->where('id', $id, '=')
            ->build();

        var_dump($sql);

        try {
            $pdoStmt = $this->pdo->prepare($sql);
            $pdoStmt->bindValue(1, $id, \PDO::PARAM_INT);
            $pdoStmt->execute();
            $result = $pdoStmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $exception) {
            throw new \PDOException('Ошибка: ' . $exception->getMessage());
        }
    }

    public function selectAll(): ?array
    {
        $sql = $this->select('*', $this->table);

        try {
            $pdoStmt = $this->pdo->prepare($sql)->execute();
            return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $exception) {
//            throw new \PDOException($exception);
            throw new NoDBConnectionException("No database connection / $exception");
        }
    }

    public function selectBy(array $criteria = null, string $orderBy = null, int $limit = null, int $offset = null): ?array
    {
        $sql = $this->select('*', $this->table)
            ->where($criteria)
            ->orderBy($orderBy)
            ->limit($limit)
            ->offset($offset)
            ->build();

        try {
            if ($pdoStmt = $this->pdo->prepare($sql)->execute()) {
                return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (\PDOException $exception) {
//            throw new \PDOException($exception);
            throw new NoDBConnectionException("No database connection / $exception");
        }
    }

    public function selectByOne(array $criteria): ?array
    {
        $sql = $this->select('*', $this->table)
            ->where($criteria)
            ->build();

        try {
            $pdoStmt = $this->pdo->prepare($sql)->execute();
            return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $exception) {
//            throw new \PDOException($exception);
            throw new NoDBConnectionException("No database connection / $exception");
        }

    }

    public function selectAllWithOffset(int $offset): ?array
    {
        $offset = ($offset - 1) * self::SELECT_LIMIT;

        $sql = $this->select('*', $this->table)
            ->limit(self::SELECT_LIMIT)
            ->offset($offset)
            ->build();

        try {
            $pdo_statement = $this->pdo->prepare($sql);
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

    public function selectAllWithOffSortByMax(string $orderBy, int $offset): ?array
    {
        $offset = ($offset - 1) * self::SELECT_LIMIT;

        $sql = $this->select('*', $this->table)
            ->orderBy($orderBy)
            ->sortDirection('DESC')
            ->limit(self::SELECT_LIMIT)
            ->offset($offset)
            ->build();

        try {
            $pdo_statement = $this->pdo->prepare($sql);
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

    public function selectAllWithOffSortByMin(string $orderBy, int $offset): ?array
    {
        $offset = ($offset - 1) * self::SELECT_LIMIT;

        $sql = $this->select('*', $this->table)
            ->orderBy($orderBy)
            ->sortDirection('ASC')
            ->limit(self::SELECT_LIMIT)
            ->offset($offset)
            ->build();

        try {
            $pdo_statement = $this->pdo->prepare($sql);
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