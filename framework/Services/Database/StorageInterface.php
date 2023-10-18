<?php

namespace Framework\Services\Database;

interface StorageInterface
{
    public function selectById(int $id);

    public function selectAll();

    public function selectBy(array $criteria = null, string $orderBy = null, int $limit = null, int $offset = null);

    public function selectByOne(array $criteria);

}