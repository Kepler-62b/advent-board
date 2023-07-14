<?php
namespace App\Controllers;

use App\Models\Advents;

class PaginationController
{

  public static function countSeparator($limit)
  {
    $count = new Advents();
    $count = $count->pdoCountRows();
    return ceil($count / $limit);
  }
}
