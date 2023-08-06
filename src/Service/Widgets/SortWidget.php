<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class SortWidget implements WidgetInterface
{
  private LinkRender $linkRender;
  private string $columnName;
  private string $filter;

  public function __construct(LinkRender $linkRender, string $columnName, string $filter)
  {
    $this->linkRender = $linkRender;
    $this->columnName = $columnName;
    $this->filter = $filter;
  }

  public function __toString()
  {
    // @TODO избавиться от метода
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/sort.php";
    $sort = ob_get_clean();
    return $sort;
  }

  public function setParams(array $params): static
  {
    $this->columnName = $params['columnName'];
    $this->filter = '&filter=' . $params['filter'];
    return $this;
  }

  public function render(): string
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/sort.php";
    $sort = ob_get_clean();
    return $sort;
  }

}