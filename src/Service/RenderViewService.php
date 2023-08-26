<?php

namespace App\Service;

class RenderViewService
{ // @TODO сделать класс для всех путей и расширений
  private const PHP_EXTANSION = '.php';
  private const EXCEPTIONS_TEMPLATE_PATH = 'src/View/templates/exceptions/';
  private const LAYOUTS_TEMPLATE_PATH = 'src/View/templates/layouts/';
  private const CONTENT_TEMPLATE_PATH = 'src/View/templates/content/';
  private const WIDGETS_TEMPLATE_PATH = 'src/View/templates/widgets/';
  private const VIEW_PATH_MAP = [
    'layouts' => self::LAYOUTS_TEMPLATE_PATH,
    'content' => self::CONTENT_TEMPLATE_PATH,
    'exceptions' => self::EXCEPTIONS_TEMPLATE_PATH,
    'widgets' => self::WIDGETS_TEMPLATE_PATH,
  ];


  private array $template = [];
  private ?array $templateParams = [];
  private ?array $templates_objects = [];

  public function __construct(array $template, array $templateParams = null)
  {
    $this->template = $template;
    $this->templateParams = $templateParams;
  }

  public function __toString(): string
  {
    return $this->renderView();
  }

  /**
   * @TODO подумать как можно использовать 
   */
  private function prepareView(object $templates_objects)
  {
    $this->templates_objects[] = $templates_objects;
  }

  public function renderView(): string
  {
    if (!is_null($this->templateParams) && !array_is_list($this->templateParams)) {
      extract($this->templateParams, EXTR_OVERWRITE);
    }

    ob_start();

    require self::VIEW_PATH_MAP[key($this->template)] . current($this->template) . self::PHP_EXTANSION;

    $content = ob_get_clean();

    return $content;

  }

}