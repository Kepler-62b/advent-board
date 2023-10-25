<?php

namespace Framework\Services\Database;

class SQLStorage implements StorageInterface
{
    public function __construct(
        private DriverInterface $PDOSQLDriver
    )
    {
    }

    /**
     * @throws ConnectionException
     */
    public function connect(): void
    {
        try {
            $this->PDOSQLDriver->connect();
        } catch (ConnectionException $connectionException) {
            throw new ConnectionException('Connection error from SQLStorage' . $connectionException);
        }
    }

    public function get(string $id): ?array
    {

        $sql = (new SQLQueryBuilder())
            ->select('*', 'adverts')
            ->whereA(['id', $id, '='], true);

        return $this->PDOSQLDriver->get($sql);
    }

    //    use SQLQueryBuilderTrait;
    //
    //    private \PDO|\PDOException $pdo;
    //
    //    private $table = 'adverts';
    //    private const SELECT_LIMIT = 10;
    //
    //    public function __construct(\PDO $pdo)
    //    {
    //        if ($pdo->connect) {
    //            $this->pdo = $pdo;
    //        } else {
    //            $this->pdo = $pdo->exception;
    //        }
    //    }
    //
    //    private function pdoStatementHandler(\PDOStatement $pdoStmt, array $bindValue): bool
    //    {
    //        // @TODO логика связывания параметров запроса
    //        for ($i = 1; $i <= count($bindValue); ++$i) {
    //            $pdoStmt->bindValue($i, $bindValue[$i - 1], \PDO::PARAM_INT);
    //        }
    //
    //        return true;
    //    }
    //
    //    public function selectById($id): ?array
    //    {
    //        $sql = $this->select('*', $this->table)
    //            ->whereA(['id', null, '='], true)
    //            ->build();
    //
    //        try {
    //            $pdoStmt = $this->pdo->prepare($sql);
    //
    //            $this->pdoStatementHandler($pdoStmt, [$id]);
    //
    //            if ($pdoStmt->execute()) {
    //                return $pdoStmt->fetch(\PDO::FETCH_ASSOC);
    //            } else {
    //                return null;
    //            }
    //        } catch (\PDOException $exception) {
    //            throw new \PDOException('Ошибка: '.$exception->getMessage());
    //        }
    //    }
    //
    //    public function selectAll(): ?array
    //    {
    //        if ($this->pdo instanceof \PDOException) {
    //            return null;
    //        }
    //
    //        $sql = $this->select('*', $this->table)
    //            ->build();
    //
    //        $pdoStmt = $this->pdo->prepare($sql);
    //        $pdoStmt->execute();
    //
    //        return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
    //    }
    //
    //    public function selectBy(array|string $criteria = null, array|string $orderBy = null, int $limit = null, int $offset = null): ?array
    //    {
    //        $sql = $this->select('*', $this->table)
    //            ->whereA($criteria)
    //            ->orderBy($orderBy, true)
    //            ->limit($limit)
    //            ->offset($offset, true)
    //            ->build();
    //
    //        try {
    //            $pdoStmt = $this->pdo->prepare($sql);
    //
    //            $this->pdoStatementHandler($pdoStmt, [$orderBy, $offset]);
    //
    //            if ($pdoStmt->execute()) {
    //                return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
    //            } else {
    //                return null;
    //            }
    //        } catch (\PDOException $exception) {
    //            //            throw new \PDOException($exception);
    //            throw new NoDBConnectionException("No database connection / $exception");
    //        }
    //    }
    //
    //
    //    public function selectAllWithOffset(int $offset): ?array
    //    {
    //        if ($this->pdo instanceof \PDOException) {
    //            return null;
    //        }
    //
    //        $offset = ($offset - 1) * self::SELECT_LIMIT;
    //
    //        $sql = $this->select('*', $this->table)
    //            ->limit(self::SELECT_LIMIT)
    //            ->offset($offset, true)
    //            ->build();
    //
    //        $pdoStmt = $this->pdo->prepare($sql);
    //
    //        $this->pdoStatementHandler($pdoStmt, [$offset]);
    //
    //        if ($pdoStmt->execute()) {
    //            return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
    //        } else {
    //            return null;
    //        }
    //    }
    //
    //    public function selectCount(): int
    //    {
    //        //        var_dump($this->selectSQL);
    //        $sql = $this->select('COUNT(*)', $this->table)
    //            ->build();
    //        //        var_dump($sql);
    //        //        die;
    //        $pdoStmt = $this->pdo->query($sql);
    //
    //        return $pdoStmt->fetch(\PDO::FETCH_NUM);
    //    }
}
