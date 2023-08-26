<?php

namespace App\Service\Widgets;

use App\Service\RenderViewService;

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
    return $template->renderView();
  }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'sort'], [
      'columnName' => $this->columnName,
      'filter' => $this->filter
    ]);
  }


}