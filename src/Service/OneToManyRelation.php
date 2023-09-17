<?php

namespace App\Service;

use App\Models\Advert;
use App\Models\Image;
use App\Repository\ImageRepository;

class OneToManyRelation
{


    public $references;

    public function __construct(string $className, int $foreignKeyValue)
    {
        $this->references = $this->fetchByForeignKey($className, $foreignKeyValue);
//        $this->references = fn() => $this->fetchByForeignKey($className, $foreignKeyValue);
    }

    private function fetchByForeignKey($className, $foreignKeyValue)
    {
        $connection = new PDOMySQL();
        $table = 'advents_prod';

        $sql = "SELECT * FROM $table WHERE id = :foreignKeyValue";

        $pdo_statement = $connection->prepare($sql);

        try {
            $pdo_statement->bindValue("foreignKeyValue", $foreignKeyValue, \PDO::PARAM_INT);
            $pdo_statement->execute();

            if ($result = $pdo_statement->fetch(\PDO::FETCH_ASSOC)) {

                return $result;
            } else {
                return null;
            }
        } catch (\PDOException $exception) {
            die('Ошибка: ' . $exception->getMessage());
        }

    }

    //    private function getData(int $foreignKeyValue): object
//    {
//        // @TODO использовать гидратор внутри метода на raw данных
//        $repository = new AdvertRepository(new PDOMySQL());
//        [$object] = $repository->findById($foreignKeyValue);
//        var_dump($object);
//        return $object;
//    }
}
