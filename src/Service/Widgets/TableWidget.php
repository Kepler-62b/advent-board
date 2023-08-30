<?php

namespace App\Service\Widgets;

use App\Service\ViewRenderService;

class TableWidget implements WidgetInterface, \Stringable
{
  private array $columnNames = [];
  private $rows;
  private ?array $linkImages = [];

  /**
   * @todo убрать из зависимостей LinkRender
   */
  public function __construct(array $columnNames, object|array $rows = null, array $linkImages = null)
  {
    $this->columnNames = $columnNames;
    $this->rows = $rows;
    $this->linkImages = $linkImages;
  }

  public function __toString(): string
  {
    $template = $this->render();
    return $template->contentRender();
  }

  public function render(): ViewRenderService
  {
    return new ViewRenderService(
      ['widgets' => 'table_model_object'],
      null,
      [
        'columnNames' => $this->columnNames,
        'rows' => $this->rows,
        'linkImages' => $this->linkImages,
      ]
    );

  }

}