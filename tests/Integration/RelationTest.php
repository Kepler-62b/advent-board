<?php
declare(strict_types=1);

namespace Tests\Integration;

use App\Repository\ImageRepository;
use App\Service\OneToManyRelation;
use App\Models\Image;
use App\Service\PHPAdventBoardDatabase;
use App\Service\Relation;
use PHPUnit\Framework\TestCase;

class RelationTest extends TestCase
{

    public static function toTestGetRepositoryDataProvider(): array
    {
        return
        [
//            'database' => ['databaseName' => 'App\Repository\PHPAdventBoardDatabase'],
            'repository' => ['repository' => 'App\Repository\ImageRepository'],
        ];
    }


    public function testGetDatabaseConnection(): PHPAdventBoardDatabase
    {
        $databaseConnection = PHPAdventBoardDatabase::getInstance();
        $this->assertInstanceOf(PHPAdventBoardDatabase::class, $databaseConnection);
        return $databaseConnection;
    }

    /**
     * @depends testGetDatabaseConnection
     * @dataProvider toTestGetRepositoryDataProvider
     */
    public function testGetRepository($repository, $databaseConnection): ImageRepository
    {
        $repository = new $repository($databaseConnection);
        $this->assertInstanceOf(ImageRepository::class, $repository);
        return $repository;
    }

    /** @depends testGetRepository */
    public function testGetModelFromRepository($repository): object
    {
        [$model] = $repository->findById(27);
        $this->assertInstanceOf(Image::class, $model);
        return $model;
    }

    /** @depends testGetModelFromRepository */
    public function testRelationInit($model): Relation
    {
        $relation = new Relation($model);
        $this->assertInstanceOf(Relation::class, $relation);
        return $relation;
    }

    /**
     * @depends testRelationInit
     */
    public function testGetRelationReturnRelationTypeObject($relation): void
    {
        $result = $relation->getRelation('itemId');

        $model = (array)$result;
        foreach ($model as $property) {
            // @TODO условие не на проверку объекта, а инстанс от того же типа, который был указан в пустой моделе
            if (is_object($property)) {
                $this->assertInstanceOf(OneToManyRelation::class, $property);
                $this->assertObjectHasProperty('relationModels', $property);
                $this->assertNotNull($property->relationModels, "AssertFail: Property model has a NULL VALUE");
            }
        }
    }

}
