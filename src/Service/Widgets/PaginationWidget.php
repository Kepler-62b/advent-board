<?php

namespace App\Service\Widgets;

use App\Service\TemplateRenderService;
use App\Service\ControllerContainer;


/** 
 * @todo соеденить пагинацию с таблицей
 */


class PaginationWidget implements WidgetInterface
{
  private const REPOSITORY = 'App\Repository\AdventRepository';
  private int $count;
  public string $widget;

  public function __construct()
  {
    $this->count = $this->countRow();
  }

  public function __toString()
  {
    $template = $this->render();
    return $template->contentRender();
   
  }

  private function countRow()
  {
    $repository = (new ControllerContainer())->get(self::REPOSITORY);
    return $repository->getCountRows();
  }

  public function render(): TemplateRenderService
  {
    return new TemplateRenderService('pagination', [
      'count' => $this->count
    ]);
  }

}