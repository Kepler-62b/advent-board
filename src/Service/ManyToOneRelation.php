<?php

namespace App\Service;

use App\Models\Image;
use App\Repository\AdvertRepository;
use App\Repository\ImageRepository;

class ManyToOneRelation
{
    public int $foreignKey;

    public array $references = [];

    public function __construct(int $foreignKey, string $className = null)
    {
        $this->foreignKey = $foreignKey;
//        $this->references[] = $this->fetchByForeignKey($foreignKey);
        $this->references = $this->getData($foreignKey);
//        $this->references = fn() => $this->getData($foreignKey);

    }

    private function getData(int $foreignKey)
    {
        $repository = new ImageRepository(new PDOMySQL());
        $objectArray = $repository->findByForeignKey($foreignKey);
        return $objectArray;
    }

    public function fetchByForeignKey(int $foreignKey): ?array
    {
        $connection = new PDOMySQL();
        $table = 'images_dev';

        $sql = "SELECT * FROM $table WHERE item_id = :foreignKeyValue";

        $pdo_statement = $connection->prepare($sql);

        try {
            $pdo_statement->bindValue("foreignKeyValue", $foreignKey, \PDO::PARAM_INT);
            $pdo_statement->execute();

            if ($result = $pdo_statement->fetchAll(\PDO::FETCH_ASSOC)) {

                return $result;
            } else {
                return null;
            }
        } catch (\PDOException $exception) {
            die('Ошибка: ' . $exception->getMessage());
        }
    }


}
