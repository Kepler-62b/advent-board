<?php
namespace App\Service;

use App\Repository\AdventRepository;

class PaginationService
{

  public static function countSeparator(AdventRepository $repository): int
  {
    $count = $repository->getCountRows();
    return ceil($count / $repository::LIMIT);
  }
}
