<?php

namespace Framework\Services\Database;

use App\Models\Advert;
use Framework\Services\HydratorService;
use Framework\Services\NoDBConnectionException;
use Framework\Services\Relation;

class SQLStorage
{
    private $connection;
    private $table = 'adverts';

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    private function pdoStatementHandler()
    {

    }

    private function statementStorage()
    {

    }

    private function selectQueryBuilder(string $orderByFilter = null, string $sortDirection = null, int $limit = null, int $offset = null)
    {

        $sqlSelect = "SELECT * FROM $this->table";

        $sqlQueryParams = [];

        $keywordValue = [
            '{ORDER BY}' => $orderByFilter,
            '{sortDirection}' => $sortDirection,
            '{LIMIT}' => $limit,
            '{OFFSET}' => $offset,
        ];

        $keywordMap = [
            '{ORDER BY}' => 'ORDER BY ',
            '{LIMIT}' => 'LIMIT ',
            '{OFFSET}' => 'OFFSET :',
        ];

        $arrayFilter = array_filter($keywordValue, function ($keyword) {
            return $keyword;
        });


        foreach ($arrayFilter as $key => $item) {
            $sqlQueryParams[] = $keywordMap[$key] . $item;
        }


        return $sqlSelect . ' ' . implode(' ', $sqlQueryParams);

    }

    public function selectById(int $id, string $entityClass): ?object
    {
        $connection = $this->connection;
        $table = $this->table;

        $sql = "SELECT * FROM $table WHERE id = :id";

        $pdo_statement = $connection->prepare($sql);

        try {
            $pdo_statement->bindValue("id", $id, \PDO::PARAM_INT);
            $pdo_statement->execute();

            if ($data = $pdo_statement->fetch(\PDO::FETCH_ASSOC)) {
                // @TODO выбрасывать fatch === false
//                throw new \Exception("row with id {$id} not found in '{$this->table}' table");

                $hydrator = new HydratorService();

                $model = $hydrator->hydrate(
                    $entityClass,
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
                return $model;
            } else {
                return NULL;
            }
        } catch (\PDOException $exception) {
            throw new \PDOException('Ошибка: ' . $exception->getMessage());
        }
    }

    public function selectAll(): ?array
    {
        $connection = $this->pdo;
        $table = $this->table;

        $sql = "SELECT * FROM $table";

        try {
            $pdo_statement = $connection->prepare($sql);
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

    public function selectAllWithLimitAndOffset(int $limit, int $dynamicOffset): ?array
    {
        $connection = $this->pdo;
        $table = $this->table;

        $offset = ($dynamicOffset - 1) * $limit;

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

    public function selectAllAndSortMax(int $limit, int $dynamicOffset, $sortDirection, $filter): ?array
    {
        $connection = $this->pdo;
        $table = $this->table;


        $offset = ($dynamicOffset - 1) * $limit;

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


}