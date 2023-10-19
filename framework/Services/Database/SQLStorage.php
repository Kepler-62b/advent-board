<?php

namespace Framework\Services\Database;

use App\Models\Advert;
use Framework\Services\HydratorService;
use Framework\Services\NoDBConnectionException;
use Framework\Services\Relation;

class SQLStorage implements StorageInterface
{

    use SQLQueryBuilderTrait;

    private \PDO $pdo;

    private $table = 'adverts';
    private const SELECT_LIMIT = 10;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function pdoStatementHandler(\PDOStatement $pdoStmt, array $bindValue): bool
    {
        // @TODO логика связывания параметров запроса
        for ($i = 1; $i <= count($bindValue); $i++) {
            $pdoStmt->bindValue($i, $bindValue[$i -1], \PDO::PARAM_INT);
        }

        return true;
    }

    public function selectById($id): ?array
    {
        $sql = $this->select('*', $this->table)
            ->whereA(['id', null, '='], true)
            ->build();

        try {
            $pdoStmt = $this->pdo->prepare($sql);

            $this->pdoStatementHandler($pdoStmt, [$id]);

            if ($pdoStmt->execute()) {
                return $pdoStmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (\PDOException $exception) {
            throw new \PDOException('Ошибка: ' . $exception->getMessage());
        }
    }

    public
    function selectAll(): ?array
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

    public
    function selectBy(array|string $criteria = null, array|string $orderBy = null, int $limit = null, int $offset = null): ?array
    {
        $sql = $this->select('*', $this->table)
            ->whereA($criteria)
            ->orderBy($orderBy, true)
            ->limit($limit)
            ->offset($offset, true)
            ->build();

        try {
            $pdoStmt = $this->pdo->prepare($sql);

            $this->pdoStatementHandler($pdoStmt, [$orderBy, $offset]);

            if ($pdoStmt->execute()) {
                return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (\PDOException $exception) {
//            throw new \PDOException($exception);
            throw new NoDBConnectionException("No database connection / $exception");
        }
    }

    public
    function selectByOne(array $criteria): ?array
    {
        $sql = $this->select('*', $this->table)
            ->whereA($criteria, true)
            ->build();

        try {
            $pdoStmt = $this->pdo->prepare($sql);

            $this->pdoStatementHandler($pdoStmt, [$criteria]);

            if ($pdoStmt->execute()) {
                return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return null;
            }
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
            ->offset($offset, true)
            ->build();

        try {
            $pdoStmt = $this->pdo->prepare($sql);

            $this->pdoStatementHandler($pdoStmt, [$offset]);

            if ($pdoStmt->execute()) {
                return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (\PDOException $exception) {
//            throw new \PDOException($exception);
            throw new NoDBConnectionException("No database connection / $exception");
        }
    }

    public
    function selectAllWithOffSortByMax(string $orderBy, int $offset): ?array
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

    public
    function selectAllWithOffSortByMin(string $orderBy, int $offset): ?array
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