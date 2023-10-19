<?php

namespace Framework\Services\Database;

interface StorageInterface
{
    public function selectById($id);

    public function selectAll();

    public function selectBy(array|string $criteria = null, array|string $orderBy = null, int $limit = null, int $offset = null);

    public function selectByOne(array $criteria);

}