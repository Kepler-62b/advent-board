<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class TableWidget implements WidgetInterface
{
  private LinkRender $linkRender;
  private array $rows;
  private array $columns = [];

  public function __construct(LinkRender $linkRender)
  {
    $this->linkRender = $linkRender;
  }

  public function __toString(): string
  {
    $linkRender = $this->linkRender;

    $columns = $this->columns;
    $rows = $this->rows;
    ob_start();
    require "src/View/widgets/table.php";
    $table = ob_get_clean();
    return $table;
  }

  // public function setParams(array $rows, array $columns): static
  // {
  //   $this->rows = $rows;
  //   $this->columns = $columns;
  //   return $this;
  // }
  public function setParams(array $params): static
  {
    $this->rows = $params['rows'];
    $this->columns = $params['columns'];
    return $this;
  }

  public function render(): string
  {
    $linkRender = $this->linkRender;
    $columns = $this->columns;
    $rows = $this->rows;
    ob_start();
    require "src/View/widgets/table.php";
    $table = ob_get_clean();
    return $table;
  }

  public function setSort($filter)
  {
    foreach ($this->columns as $column) {
      if ($column === $filter) {
        var_dump($column);
        $sortLink = "<a href='/show/price/min/?page=1&filter=$filter'>$column</a>";
        // return $sortLink;
      }
    }
  }








}