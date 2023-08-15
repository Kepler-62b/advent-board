<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;
use App\Service\ControllerContainer;

class PaginationWidget implements WidgetInterface
{
  private LinkRender $linkRender;

  public string $widget;

  public function __construct(LinkRender $linkRender)
  {
    $this->linkRender = $linkRender;
  }

  public function countRow()
  {
    $repository = (new ControllerContainer())->get('App\Repository\AdventRepository');
    return $repository->getCountRows();
  }

  public function render(): string
  {
    $linkRender = $this->linkRender;
    $count = $this->countRow();
    ob_start();
    require "src/View/widgets/pagination.php";
    $navigation = ob_get_clean();
    return $navigation;
  }

}