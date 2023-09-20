<?php

namespace Tests\Unit;

use App\Models\Advent;
use App\Models\Advert;
use App\Models\Image;
use App\Service\HydratorService;
use PHPUnit\Framework\TestCase;

class HydratorServiceTest extends TestCase
{
    private HydratorService $hydrator;

    protected function setUp(): void
    {
        $this->hydrator = new HydratorService();
    }

    public static function toTestHydrateModelDataProvider(): array
    {
        return [
            'AdventModel' =>
                [
                    'className' => Advent::class,
                    'data' =>
                        [
                            'id' => 1,
                            'item' => 'first item',
                            'description' => 'first desc',
                            'price' => 111,
                            'image' => 'first.png',
                            'created_date' => '2023-06-23 11:11:11',
                            'modified_date' => '2023-06-29 11:11:11',
                        ],
                    'map' =>
                        [
                            'id' => 'id',
                            'item' => 'item',
                            'description' => 'description',
                            'price' => 'price',
                            'image' => 'image',
                            'created_date' => 'createdDate',
//                            'modified_date' => 'modifiedDate',
                        ]
                ],
            'AdvertModel' =>
                [
                    'className' => Advert::class,
                    'data' =>
                        [
                            'id' => 1,
                            'item' => 'ITEM',
                            'description' => 'DESCRIPTION',
                            'price' => 111,
                            'image' => 'IMAGE.JPEG',
                            'created_date' => '2023-06-23 11:11:11',
//                            'modified_date' => '2023-06-29 11:11:11',
                        ],
                    'map' =>
                        [
                            'id' => 'id',
                            'item' => 'item',
                            'description' => 'description',
                            'price' => 'price',
                            'image' => 'image',
//                            'created_date' => 'createdDate',
//                            'modified_date' => 'modifiedDate',
                        ]
                ],
            'ImageModel' =>
                [
                    'className' => Image::class,
                    'data' =>
                        [
                            'id' => 1,
                            'name' => 'name',
                            'item_id' => 111,
                        ],
                    'map' => [
                        'id' => 'id',
                        'name' => 'name',
                        'item_id' => 'itemId',
                    ]
                ]
        ];
    }

    /**
     * @dataProvider toTestHydrateModelDataProvider
     */
    public function testHydrateModel(string $className, array $data, array $map): void
    {
        $result = $this->hydrator->hydrate($className, $data, $map);

        $this->assertInstanceOf($className, $result, "Hydrate model is not instanceof $className class");
        $this->assertIsObject($result);

        $model = (array)$result;

        foreach ($map as $key => $property) {
            if (property_exists($result, $property) && array_key_exists($key, $data)) {
                $this->assertNotNull($model["\0$className\0$property"], "AssertFail: Property $property is NULL VALUE");
            }
        }
    }
}