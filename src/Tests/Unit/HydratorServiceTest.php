<?php

namespace App\Tests\Unit;

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

  public static function totestHydrateModelDataProvider(): array
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
              'modified_date' => 'modifiedDate',
            ]
        ],
      'AdvertModel' =>
        [
          'className' => Advert::class,
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
              'modified_date' => 'modifiedDate',
            ]
        ],
      'ImageModel' =>
        [
          'className' => Image::class,
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
          'map' => [
            'id' => 'id',
            'item' => 'name',
            'price' => 'item_id',
          ]
        ]
    ];
  }

  /**
   * @dataProvider totestHydrateModelDataProvider
   */
  public function testHydrateModel(string $className, array $data, array $map): void
  {
    $result = $this->hydrator->hydrate($className, $data, $map);

    $modelMethods = get_class_methods($result);
    $gettersStorage = array_filter($modelMethods, function ($value) {
      return str_contains($value, 'get');
    });

    foreach ($gettersStorage as $getter) {
      $this->assertNotNull($result->$getter());
    }
    $this->assertInstanceOf($className, $result);


  }

}