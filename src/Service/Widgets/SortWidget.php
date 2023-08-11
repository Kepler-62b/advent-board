<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class SortWidget implements WidgetInterface
{
  private LinkRender $linkRender;
  private string $columnName;
  private string $filter;
  public string $widget;

  public function __construct(LinkRender $linkRender, string $columnName, string $filter)
  {
    $this->linkRender = $linkRender;
    $this->columnName = $columnName;
    $this->filter = 'filter=' . $filter;
    $this->widget = self::renderWidget();
  }

  public function renderWidget(): string
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/sort.php";
    $sort = ob_get_clean();
    return $sort;
  }


}