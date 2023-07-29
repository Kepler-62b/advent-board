<?php

namespace App\Service;

use App\Models\Advent;
use App\Repository\AdventRepository;

class TableWidget extends WidgetRender
{
  private $columns = [];
  private $rows;

  public function __construct(array $rows)
  {
    $this->rows = $rows;
  }

  public function setColumns($columns)
  {
    $this->columns = $columns;
    return $this;
  }

  public function render()
  {
    ob_start();
    require "src/View/widgets/table.php";
    $widget = ob_get_clean();
    return $widget;
  }

  public function setSort($filter, $direction)
  {

  }

  public static function renderWidget($table): void
  {
    echo $table;
  }




}