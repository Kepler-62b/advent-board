<?php
declare(strict_types=1);

namespace Tests\Integration;

use App\Service\OneToManyRelation;
use App\Models\Image;
use App\Service\Relation;
use PHPUnit\Framework\TestCase;

class RelationTest extends TestCase
{

    public static function toTestModelInit(): array
    {
        return
            [
                'ImageModel' => ['modelClassname' => Image::class, 'name' => 'moto.png', 'itemId' => 50],
            ];
    }

    protected function testModelInit($modelName, $name, $itemId)
    {
        $model = new $modelName($name, $itemId);
        $this->assertInstanceOf($modelName, $model);
        $this->assertIsObject($model);
        return $model;
    }

    protected function testRelationInit($modelName, $name, $itemId)
    {
        $model = $this->testModelInit($modelName, $name, $itemId);
        $relation = new Relation($model);
        $this->assertIsObject($relation);
        return $relation;
    }

    /**
     * @dataProvider toTestModelInit
     */
    public function testGetRelationReturnRelationTypeObject($modelName, $name, $itemId): void
    {
        $relation = $this->testRelationInit($modelName, $name, $itemId);
        $result = $relation->getRelation('itemId');
//        dd($result);

        $model = (array)$result;

        foreach ($model as $property) {
            // @TODO условие не на проверку объекта, а инстанс от того же типа, который был указан в пустой моделе
            if (is_object($property)) {
                $this->assertInstanceOf(OneToManyRelation::class, $property);
                $this->assertObjectHasProperty('relationModels', $property);
                $this->assertNotNull($property->relationModels, "AssertFail: Property model has a NULL VALUE");
            }
        }

        // @TODO наполнять модель данными полностью
    }


    public function testGetRelationHydrateRelationTypeObject(): void
    {
        $relation = new OneToManyRelation(65, Image::class);
        $this->assertNotNull($relation->relationModels);
    }


}
