<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class TableWidget implements WidgetInterface, \Stringable
{
  private LinkRender $linkRender;
  private ?array $rows = [];
  private array $columnNames = [];
  private ?array $linkImages = [];
  public string $widget;

  public function __construct(LinkRender $linkRender, ?array $rows, array $columnNames, ?array $linkImages)
  {
    $this->linkRender = $linkRender;
    $this->rows = $rows;
    $this->columnNames = $columnNames;
    $this->linkImages = $linkImages;
    $this->widget = self::renderWidget();
  }

  public function __toString(): string
  {
    $linkRender = $this->linkRender;
    $columnNames = $this->columnNames;
    $rows = $this->rows;
    ob_start();
    require "src/View/widgets/table.php";
    $table = ob_get_clean();
    return $table;
  }

  public function renderWidget(): string
  {
    $linkRender = $this->linkRender;
    $columnNames = $this->columnNames;
    $rows = $this->rows;
    ob_start();
    require "src/View/widgets/table.php";
    $table = ob_get_clean();
    return $table;
  }

}