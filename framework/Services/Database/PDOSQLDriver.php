<?php

namespace Framework\Services\Database;

use Framework\Services\Database\ConnectionException;

final class PDOSQLDriver implements DriverInterface
{
    private \PDO $pdo;

    public function __construct(
        private string $dsn,
        private string $user,
        private string $pass,
    )
    {
    }

    /**
     * @throws \ConnectionException
     */
    public function connect(): void
    {
        try {
            $this->pdo = new \PDO($this->dsn, $this->user, $this->pass);
        } catch (\PDOException $exception) {
            throw new ConnectionException('PDOException / PDOSQLDriver connect error ' . $exception);
        }
    }

    // вернет массив с занчениями из БД или пустой массив
    public function execute(string $sql, array $params = null): array
    {
        $pdo = $this->pdo;

        $pdoStmt = $pdo->prepare($sql);

        if (isset($params)) {
            for ($i = 1; $i <= count($params); ++$i) {
                // подумать как задавать через массив параметов для связанного параметра константу типа - \PDO::PARAM_INT, \PDO::PARAM_STRING, etc
                $pdoStmt->bindValue($i, $params[$i - 1], \PDO::PARAM_INT);
            }
        }

        $pdoStmt->execute();

        return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
