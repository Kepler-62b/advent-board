<?php

namespace App\Controllers;

use App\Models\Advent;
use App\Models\Image;

class ShowController
{
  // methods for rows
  public function showRows($id = null)
  {
    return (new Advent())->pdoGetRows($id);
  }

  public function showRow($id)
  {
    $result = (new Advent())->pdoGetRow($id);
    if (empty($result)) {
      $unknown = array(
        'id' => 'unknown value',
        'item' => 'unknown value',
        'description' => 'unknown value',
        'price' => 'unknown value',
        'image' => 'system\image_unknown_value.png',
      );
      array_push($result, $unknown);
      return $result;
    } elseif ($result[0]['image'] === NULL) {
      $result[0]['image'] = "system\image_not_found.png";
      return $result;
    } else {
      return $result;
    }
  }

  public function showSortRow($sort, $page, $row)
  {
    return (new Advent())->pdoSortRow($sort, $page, $row);
  }

  public function showEmptyRows($sort, array $param)
  {
    if(key_exists('filter', $param)) {
      $filter = $param['filter'];
    } else {
      $filter = NULL;
    }
    if(key_exists('page', $param)) {
      $page = $param['page'];
    } else {
      $page = 1;
    }
    return (new Advent())->pdoSortRow($sort, $page, $filter);
  }

  // method for images
  public function showImages($id)
  {
    return (new Image())->pdoGetRow($id);
  }
}
