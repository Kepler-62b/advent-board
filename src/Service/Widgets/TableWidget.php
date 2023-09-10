<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateServise;
use App\Service\TemplateNavigator;
use App\Service\ViewRenderService;

class TableWidget implements WidgetInterface
{
  private array $columnNames = [];
  private $data;
  private ?array $linkImages = [];

  /**
   * @todo убрать из зависимостей LinkRender
   */
  public function __construct(array $columnNames, object|array $data = null, array $linkImages = null)
  {
    $this->columnNames = $columnNames;
    $this->data = $data;
    $this->linkImages = $linkImages;
  }

  public function __toString(): string
  {
    return (new RenderTemplateServise([$this->getTemplate()]))->renderFromListTemplates();

    // $template = $this->render();
    // return $template->contentRender();
  }

  public function render(): ViewRenderService
  {
    return new ViewRenderService(
      ['widgets' => 'table_array_object_model'],
      null,
      [
        'columnNames' => $this->columnNames,
        'adverts' => $this->data,
        'linkImages' => $this->linkImages,
      ]
    );

  }

  public function getTemplate(): TemplateNavigator
  {
    return new TemplateNavigator('table_array_object_model', 'widgets', ['columnNames' => $this->columnNames, 'adverts' => $this->data]);
  }

}