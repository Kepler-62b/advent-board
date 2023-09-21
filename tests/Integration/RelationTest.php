<?php
declare(strict_types=1);

namespace Tests\Integration;

use App\Service\Relation;
use PHPUnit\Framework\TestCase;

class RelationTest extends TestCase
{

    public static function toTestGetRepositoryDataProvider(): array
    {
        return
            [
                'ImageModel' => [
                    'databaseName' => 'App\Service\PHPAdventBoardDatabase',
                    'repositoryName' => 'App\Repository\ImageRepository',
                    'modelName' => 'App\Models\Image',
                    'imageId' => 27,
                    'relationColumn' => 'itemId',
                    'relationType' => 'App\Service\OneToManyRelation'
                ],
                'Advert' => [
                    'databaseName' => 'App\Service\PHPAdventBoardDatabase',
                    'repositoryName' => 'App\Repository\AdvertRepository',
                    'modelName' => 'App\Models\Advert',
                    'advertId' => 1,
                    'relationColumn' => 'id',
                    'relationType' => 'App\Service\ManyToOneRelation'
                ],
            ];
    }

    /**
     * @dataProvider toTestGetRepositoryDataProvider
     */
    public function testGetRelation($databaseName, $repositoryName, $modelName, $imageId, $relationColumn, $relationType)
    {
        $databaseConnection = $databaseName::getInstance();
        $this->assertInstanceOf($databaseName, $databaseConnection);

        $repository = new $repositoryName($databaseConnection);
        $this->assertInstanceOf($repositoryName, $repository);

        [$model] = $repository->findById($imageId);
        $this->assertInstanceOf($modelName, $model);

        $relation = new Relation($model);
        $this->assertInstanceOf(Relation::class, $relation);

        $result = $relation->getRelation($relationColumn);
        $model = (array)$result;
        foreach ($model as $property) {
            if ($property instanceof $relationType) {
                $this->assertObjectHasProperty('relationModels', $property, "AssertFail: Object $relationType has no property 'relationModels'");
                $this->assertNotNull($property->relationModels, "AssertFail: Property model has a NULL VALUE");
            }
        }
//        dd($result);
    }

}
