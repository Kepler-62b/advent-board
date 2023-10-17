<?php

namespace Tests\Unit;

use App\Models\Advent;
use App\Models\Advert;
use App\Models\Image;
use Framework\Services\OneToManyRelation;
use PHPUnit\Framework\TestCase;

final class OneToManyRelationTest extends TestCase
{
    public static function positiveTestingDataProvider(): array
    {
        return [
            'GetRelationModelInstance' => ['foreignKey' => 1, 'modelName' => Advert::class],
        ];
    }

    public static function negativeTestingDataProvider(): array
    {
        return [
            'NotFoundMethodException' => ['foreignKey' => 1, 'modelName' => Advent::class],
            'NotFoundForeignKeyException' => ['foreignKey' => 1, 'modelName' => Image::class],
        ];
    }

    /** @dataProvider positiveTestingDataProvider */
    public function testGetRelationModelInstance($foreignKey, $modelName): void
    {
        $relation = new OneToManyRelation($foreignKey, $modelName);
        $this->assertInstanceOf(OneToManyRelation::class, $relation);
        $this->assertNotNull($relation->relationModels);
    }

    /** @dataProvider negativeTestingDataProvider */
    public function testException($foreignKey, $modelName): void
    {
        $this->expectException(\Exception::class);
        $relation = new OneToManyRelation($foreignKey, $modelName);
    }


}
