<?php

namespace App\Service;

use App\Repository\ImageRepository;

class OneToManyRelation
{

    public int $foreignKey;
    public object $references;

    public function __construct(int $foreignKey)
    {
        $this->foreignKey = $foreignKey;
        $this->references = $this->getData($foreignKey);
    }

    private function getData(int $foreignKey): object
    {
        // var_dump($foreignKey);
        $repository = new ImageRepository(new PDOMySQL());
        [$object] = $repository->findByForeignKey($foreignKey);
        // var_dump($object);
        return $object;
    }
}
