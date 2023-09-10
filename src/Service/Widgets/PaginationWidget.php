<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateServise;
use App\Service\RenderViewService;
use App\Service\ControllerContainer;
use Dev\Tests\Services\TemplateNavigator;


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

  public function __toString(): string
  {
    return (new RenderTemplateServise([$this->getTemplate()]))->renderFromListTemplates();

    // $template = $this->render();
    // return $template->renderView();
  }

  private function countRow()
  {
    $repository = (new ControllerContainer())->get(self::REPOSITORY);
    return ceil($repository->getCount()/$repository::SELECT_LIMIT);
  }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'pagination'], ['count' => $this->count]);
  }

  public function getTemplate(): TemplateNavigator
  {
   return new TemplateNavigator('pagination', 'widgets', ['count' => $this->count]);
  }


  

}