<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class SortWidget implements WidgetInterface
{
  private LinkRender $linkRender;
  private string $columnName;
  private string $filter;

  public function __construct(LinkRender $linkRender)
  {
    $this->linkRender = $linkRender;
  }

  public function __toString()
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/sort.php";
    $sort = ob_get_clean();
    return $sort;
  }

  // public function setParams(string $column, string $filter): static
  // {
  //   $this->columnName = $column;
  //   $this->filter = "&filter=" . $filter;
  //   return $this;
  // }
  public function setParams(array $params): static
  {
    $this->columnName = $params['columnName'];
    $this->filter = $params['filter'];
    return $this;
  }

  // public function render()
  // {
  //   if (str_contains($this->getPath(), "min")) {
  //     return "▲";
  //   } elseif (str_contains($this->getPath(), "max")) {
  //     return "▼";
  //   }
  // }

  public function render(): string
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/sort.php";
    $sort = ob_get_clean();
    return $sort;
  }

}