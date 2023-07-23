<?php
namespace App\Controllers;

use App\Repository\AdventRepository;

class PaginationController
{

  public static function countSeparator(AdventRepository $repository, int $limit): int
  {
    $count = $repository->getCountRows();
    return ceil($count / $limit);
  }
}
