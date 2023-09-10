<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateServise;
use App\Service\RenderViewService;
use App\Service\TemplateNavigator;

class SortWidget implements WidgetInterface
{
  private string $columnName;
  private string $filter;

  public function __construct(string $columnName, string $filter)
  {
    $this->columnName = $columnName;
    $this->filter = $filter;
  }

  public function __toString(): string
  {
    return (new RenderTemplateServise([$this->getTemplate()]))->renderFromListTemplates();

    // $template = $this->render();
    // return $template->renderView();
  }

  public function render(): RenderViewService
  {
    // @TODO  возвращать объект Template с названием шаблона и передавать его в Render
    return new RenderViewService(['widgets' => 'sort'], [
      'columnName' => $this->columnName,
      'filter' => $this->filter
    ]);
  }

  public function getTemplate()
  {
   return new TemplateNavigator('sort', 'widgets', ['columnName' => $this->columnName, 'filter' => $this->filter]);
  }


}