<?php

namespace Framework\Services\Database;

final class PDOSQLDriver implements DriverInterface
{
    private \PDO $pdo;

    public function __construct(
        private string $dsn,
        private string $user,
        private string $pass,
    ) {
    }

    /**
     * @throws ConnectionException
     */
    public function connect(): void
    {
        try {
            $this->pdo = new \PDO($this->dsn, $this->user, $this->pass);
        } catch (\PDOException $exception) {
            throw new ConnectionException('Connect error from PDOSQLDriver / PDOException /  '.$exception);
        }
    }

    // надстройка над pdo_stmt->execute
    public function get(SQLQueryBuilder $queryBuilder): array
    {
        $pdo = $this->pdo;

        $pdoStmt = $pdo->prepare($queryBuilder->build());

        if (!empty($queryBuilder->bindValue)) {
            for ($i = 1; $i <= count($queryBuilder->bindValue); ++$i) {
                // подумать как задавать через массив параметов для связанного параметра константу типа - \PDO::PARAM_INT, \PDO::PARAM_STRING, etc
                $pdoStmt->bindValue($i, $queryBuilder->bindValue[$i - 1], \PDO::PARAM_INT);
            }
        }

        $pdoStmt->execute();

        return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDriverName(): string
    {
        return \PDO::class;
    }
}
