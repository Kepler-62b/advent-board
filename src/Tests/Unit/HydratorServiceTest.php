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

  /**
   * @dataProvider modelAdventDataProvider
   */
  public function testHydrateAdventModel(array $data, array $map): void
  {

    $result = $this->hydrator->hydrate(Advent::class, $data, $map);

    $this->assertInstanceOf(Advent::class, $result);
    $this->assertNotEmpty($result);

  }

  public static function modelAdventDataProvider(): array
  {
    return [
      'Advent' =>
      [
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
    ];
  }
  public static function modelAdvertDataProvider(): array
  {
    return [
      'Advent' =>
      [
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
    ];
  }




  // public function testHydrateImageModel(): void
  // {
  //   $data = [
  //     'id' => 1,
  //     'item' => 'first item',
  //     'description' => 'first desc',
  //     'price' => 111,
  //     'image' => 'first.png',
  //     'created_date' => '2023-06-23 11:11:11',
  //     'modified_date' => '2023-06-29 11:11:11',
  //   ];

  //   $map = [
  //     'id' => 'id',
  //     'name' => 'item',
  //     'item_id' => 'price',
  //   ];

  //   $result = $this->hydrator->hydrate(Image::class, $data, $map);

  //   $this->assertInstanceOf(Image::class, $result);
  //   $this->assertNotEmpty($result);
  //   $this->assertObjectHasProperty('name', $result);

  // }

}