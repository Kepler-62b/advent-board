<?php

namespace App\Service\Widgets;

class TableWidget implements WidgetInterface
{
  private $columns = [];
  private $rows;

  public function __construct(array $rows)
  {
    $this->rows = $rows;
  }

  public function __toString()
  {
    ob_start();
    require "src/View/widgets/table.php";
    $widget = ob_get_clean();
    return $widget;
  }

  public function setColumns($columns)
  {
    $this->columns = $columns;
    return $this;
  }

  public function render(): string
  {
    ob_start();
    require "src/View/widgets/table.php";
    $widget = ob_get_clean();
    return $widget;
  }

  public function setSort($filter, $direction)
  {

  }








}