<?php

namespace App\Service;
use App\Repository\AdventRepository;

class WidgetRender
{

  public static function navigationWidget(): void
  {
    require 'src/View/widgets/navigation.php';
    echo $navigationWidget;
  }

  public static function paginationWidget(): void
  {
    $repository = (new ControllerContainer())->get(AdventRepository::class);
    require 'src/View/widgets/pagination.php';
    echo $paginationWidget;
  }
}