<?php

namespace Tests\Integration;

use App\Models\Image;
use App\Service\Relation;
use PHPUnit\Framework\TestCase;

class RelationTest extends TestCase
{
    private Relation $relation;

    protected function setUp(): void
    {
        $this->relation = new Relation(new Image('name', 65));
    }

    public function testGetRelation()
    {
        $relation = $this->relation;
        $relation->getRelation('itemId');
        var_dump($relation);
    }

}
