<?php

namespace App\Service\Widgets;

/** 
 * @todo соеденить пагинацию с таблицей
 */

use App\Service\LinkRender;
use App\Service\ControllerContainer;

class PaginationWidget implements WidgetInterface
{
  private const REPOSITORY = 'App\Repository\AdventRepository';
  private LinkRender $linkRender;
  private int $count;
  public string $widget;

  public function __construct(LinkRender $linkRender)
  {
    $this->linkRender = $linkRender;
    $this->count = $this->countRow();
  }

  public function countRow()
  {
    $repository = (new ControllerContainer())->get(self::REPOSITORY);
    return $repository->getCountRows();
  }

  public function render(): string
  {
    $linkRender = $this->linkRender;
    $count = $this->count;
    ob_start();
    require "src/View/widgets/pagination.php";
    $navigation = ob_get_clean();
    return $navigation;
  }

}