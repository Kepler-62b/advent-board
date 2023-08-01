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

}