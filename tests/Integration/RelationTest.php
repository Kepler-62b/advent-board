<?php
declare(strict_types=1);

namespace Tests\Integration;

use App\Service\OneToManyRelation;
use App\Models\Image;
use App\Service\Relation;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Depends;

class RelationTest extends TestCase
{
    private Relation $relation;
    private Image $imageModel;
    private object $database;

    public static function toTestModelInit(): array
    {
        return
            [
                'ImageModel' => ['modelClassname' => Image::class, 'name' => 'moto.png', 'itemId' => 50],
            ];
    }

    /**
     * @dataProvider toTestModelInit
     * */
    public function testModelInit($modelName, $name, $itemId): object
    {
        $model = new $modelName($name, $itemId);
        $this->assertInstanceOf($modelName, $model);
        $this->assertIsObject($model);
        return $model;
    }

    /**
     * @depends testModelInit
     */
    public function testRelationInit(object $model): object
    {
        $this->assertIsObject($model);
        $relation = new Relation($model);
        $this->assertIsObject($relation);
        return $relation;
    }

    /**
     * @depends testRelationInit
     */
    public function testGetRelationReturnRelationTypeObject($relation): void
    {
        $result = $relation->getRelation('itemId');
        var_dump($result);

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
