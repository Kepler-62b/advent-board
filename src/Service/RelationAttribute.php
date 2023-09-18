<?php

namespace App\Service;

#[\Attribute]
class RelationAttribute
{
    public string $relationModel;

    public function __construct(string $relationModel)
    {
        $this->relationModel = $relationModel;
    }

}