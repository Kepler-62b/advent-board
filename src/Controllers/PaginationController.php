<?php
namespace App\Controllers;

use App\Models\Advent;

class PaginationController
{

  public static function countSeparator($limit)
  {
    $count = new Advent();
    $count = $count->pdoCountRows();
    return ceil($count / $limit);
  }
}
