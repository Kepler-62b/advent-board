<?php

namespace Framework\Services\Database;


final class PDOSQLDriver implements DriverInterface
{

//    use PDOSingletonTrait;

    private ?\PDO $pdoS = null;

    private \PDO $pdo;

    public function __construct(
        private string $dsn,
        private string $user,
        private string $pass,
    )
    {
    }


    /**
     * @throws ConnectionException
     */
    public function connect(): void
    {
        try {
            $this->pdo = new \PDO($this->dsn, $this->user, $this->pass);
            var_dump($this->pdo);
        } catch (\PDOException $exception) {
            throw new ConnectionException('Connect error from PDOSQLDriver / PDOException /  ' . $exception);
        }
    }

    /**
     * @throws ConnectionException
     */

    public function connect(): void
    {
        try {

            if(!isset($this->pdoS)) {
                $this->pdoS = new \PDO($this->dsn, $this->user, $this->pass);
            }

        } catch (\PDOException $exception) {
            throw new DriverException('PDOException /  ' . $exception);
        }
    }

    public function get(QueryBuilderInterface $queryBuilder): array
    {
        $pdoStmt = $this->pdoS->prepare($queryBuilder->build());
//        $pdoStmt = $this->pdo->prepare($queryBuilder->build());

        $bindValue = $queryBuilder->get();

        $typeMap = [
            'integer' => \PDO::PARAM_INT,
            'string' => \PDO::PARAM_STR,
        ];

        if ($bindValue) {
            for ($i = 1; $i <= count($bindValue); ++$i) {
                $pdoStmt->bindValue($i, $bindValue[$i - 1], $typeMap[gettype($bindValue[$i - 1])]);
            }
        }

        $pdoStmt->execute();

        return $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDriverName(): string
    {
        return PDOSQLDriver::class;
    }
}
