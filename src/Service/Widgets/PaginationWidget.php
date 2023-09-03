<?php

namespace App\Service\Widgets;

use App\Service\RenderViewService;
use App\Service\ControllerContainer;


/** 
 * @todo соеденить пагинацию с таблицей
 */


class PaginationWidget implements WidgetInterface
{
  private const REPOSITORY = 'App\Repository\AdventRepository';
  private int $count;

  public function __construct()
  {
    $this->count = $this->countRow();
  }

  public function __toString()
  {
    $template = $this->render();
    return $template->renderView();
  }

  private function countRow()
  {
    $repository = (new ControllerContainer())->get(self::REPOSITORY);
    var_dump($repository->getCount());
    return $repository->getCount();
  }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'pagination'], ['count' => $this->count]);
  }


  

}