<?php

namespace Framework\Services\Database;

interface QueryBuilderInterface
{
    public function get(): ?array;
}