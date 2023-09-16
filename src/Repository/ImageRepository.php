<?php

namespace App\Repository;

use App\Service\PDOMySQL;
use App\Models\Image;
use App\Service\HydratorService;
use ReflectionException;

class ImageRepository
{
    private PDOMySQL $pdo;
    private string $table = 'images_dev';
    public const SELECT_LIMIT = 5;

    public function __construct(PDOMySQL $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Image[]
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
                $modelsStorage[] = $hydrator->hydrate(
                    Image::class,
                    $data,
                    [
                        'id' => 'id',
                        'name' => 'name',
                        'item_id' => 'item_id',
                    ]
                );
            }
            return $modelsStorage;
        } catch (\PDOException $exception) {
            throw new \PDOException($exception);
        }
    }

    /**
     * @param int $id
     * @return Image[]
     * @throws ReflectionException
     */
    public function findById(int $id): ?array
    {
        $connection = $this->pdo;
        $table = $this->table;

        $sql = "SELECT * FROM $table WHERE id = :id";

        $pdo_statement = $connection->prepare($sql);

        try {
            $pdo_statement->bindValue("id", $id, \PDO::PARAM_INT);
            $pdo_statement->execute();

            if ($result = $pdo_statement->fetch(\PDO::FETCH_ASSOC)) {

                $hydrator = new HydratorService();

                $model[] = $hydrator->hydrate(
                    Image::class,
                    $result,
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
                return null;
            }
        } catch (\PDOException $exception) {
            die('Ошибка: ' . $exception->getMessage());
        }
    }

    public function findByForeignKey(int $foreignKeyValue): ?array
    {
        $connection = $this->pdo;
        $table = $this->table;

        $sql = "SELECT * FROM $table WHERE item_id = :foreignKeyValue";

        $pdo_statement = $connection->prepare($sql);

        try {
            $pdo_statement->bindValue("foreignKeyValue", $foreignKeyValue, \PDO::PARAM_INT);
            $pdo_statement->execute();

            if ($result = $pdo_statement->fetch(\PDO::FETCH_ASSOC)) {

                $hydrator = new HydratorService();
                $models = [];

                $models[] = $hydrator->hydrate(
                    Image::class,
                    $result,
                    [
                        'id' => 'id',
                        'name' => 'name',
                        'item_id' => 'item_id',
                    ]
                );
                
//                foreach ($result as $data) {
//                    $models[] = $hydrator->hydrate(
//                        Image::class,
//                        $data,
//                        [
//                            'id' => 'id',
//                            'name' => 'name',
//                            'item_id' => 'item_id',
//                        ]
//                    );
//                }
                return $models;
            } else {
                return null;
            }
        } catch (\PDOException $exception) {
            die('Ошибка: ' . $exception->getMessage());
        }
    }
}
