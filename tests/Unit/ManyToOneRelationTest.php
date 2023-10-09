<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Service\ManyToOneRelation;
use PHPUnit\Framework\TestCase;

final class ManyToOneRelationTest extends TestCase
{

    public static function toPositiveTesting(): array
    {
        return [
            'testGetInstance' => ['relationKey' => 50, Image::class],
        ];
    }

    public static function toNegativeTesting(): array
    {
        return [
            'testGetInstance' => ['relationKey' => 1000, Image::class],
        ];
    }

    /** @dataProvider toPositiveTesting */
    public function testManyToIneInstance($relationKey, $modelName): void
    {
        $relation = new ManyToOneRelation($relationKey, $modelName);
        $this->assertInstanceOf(ManyToOneRelation::class, $relation);
        $this->assertNotNull($relation->relationModels);
    }

    /** @dataProvider toNegativeTesting */
    public function testExceptions($relationKey, $modelName): void
    {
        $this->expectException(\Exception::class);
        $relation = new ManyToOneRelation($relationKey, $modelName);
    }

}
