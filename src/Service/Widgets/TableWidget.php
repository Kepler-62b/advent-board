<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class TableWidget implements WidgetInterface, \Stringable
{
  private LinkRender $linkRender;
  private ?array $rows = [];
  private array $columnName = [];
  private ?array $linkImages = [];
  public string $widget;

  public function __construct(LinkRender $linkRender, ?array $rows, array $columnName, ?array $linkImages)
  {
    $this->linkRender = $linkRender;
    $this->rows = $rows;
    $this->columnName = $columnName;
    $this->linkImages = $linkImages;
    $this->widget = self::renderWidget();
  }

  public function __toString(): string
  {
    $linkRender = $this->linkRender;
    $columnName = $this->columnName;
    $rows = $this->rows;
    ob_start();
    require "src/View/widgets/table.php";
    $table = ob_get_clean();
    return $table;
  }

  public function renderWidget(): string
  {
    $linkRender = $this->linkRender;
    $columnName = $this->columnName;
    $rows = $this->rows;
    ob_start();
    require "src/View/widgets/table.php";
    $table = ob_get_clean();
    return $table;
  }

}