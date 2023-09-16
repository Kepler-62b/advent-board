<?php

namespace App\Service;

#[\Attribute]
class RelationAttribute
{
    public string $relation;

    public function __construct(string $relation)
    {
        $this->relation = $relation;
    }

}