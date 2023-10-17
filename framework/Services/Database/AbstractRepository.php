<?php

namespace Framework\Services\Database;

use Doctrine\Persistence\ObjectRepository;

class AbstractRepository
{
    private $storage;
    private $entityClass;

    public function __construct($storage, $entityClass)
    {
        $this->storage = $storage;
        $this->entityClass = $entityClass;
    }

    public function find($id)
    {
        $storage = $this->storage;
        $entity = $this->entityClass;
        return $storage->selectById($id, $entity);
    }


}