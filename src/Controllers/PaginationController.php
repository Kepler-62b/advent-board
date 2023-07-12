<?php

class PaginationController
{

  public static function countSeparator($limit)
  {
    $count = new Advents();
    $count = $count->pdoCountRows();
    return ceil($count / $limit);
  }
}
