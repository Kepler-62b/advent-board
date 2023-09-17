<?php

namespace App\Service;

class RelationObject
{
    protected PDOMySQL $mySQL;

    protected string $table = 'advents_prod';

    public function __construct()
    {
        $this->mySQL = new PDOMySQL();
    }





}