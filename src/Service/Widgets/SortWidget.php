<?php

namespace App\Service\Widgets;

use App\Service\TemplateRenderService;

class SortWidget implements WidgetInterface
{
  private string $columnName;
  private string $filter;

  public function __construct(string $columnName, string $filter)
  {
    $this->columnName = $columnName;
    $this->filter = $filter;
  }

  public function __toString()
  {
    $template = $this->render();
    return $template->contentRender();
  }

  public function render(): TemplateRenderService
  {
    return new TemplateRenderService('sort', [
      'columnName' => $this->columnName,
      'filter' => $this->filter
    ]);
  }


}