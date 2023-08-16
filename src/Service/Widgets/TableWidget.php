<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;
use App\Service\TemplateRenderService;

class TableWidget implements WidgetInterface, \Stringable
{
  private LinkRender $linkRender;
  private array $columnNames = [];
  private ?array $rows = [];
  private ?array $linkImages = [];

  /**
   * @todo убрать из зависимостей LinkRender
   */
  public function __construct(array $columnNames, ?array $rows, ?array $linkImages)
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

  public function render(): TemplateRenderService
  {
    return new TemplateRenderService(
      'table_alt',
      [
        'columnNames' => $this->columnNames,
        'rows' => $this->rows,
        'linkImages' => $this->linkImages,
      ]
    );

  }

}