<?php

namespace Framework\Services;

//@TODO подумать над названием класса и методов в нем

class ViewRenderService
{
  // @TODO сделать класс для всех путей и расширений
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

  private array $template;

  private ?array $layout = [];

  private ?array $params = [];

  public function __construct(array $template, array $layout = null, array $params = null)
  {
    $this->template = $template;
    $this->params = $params;
    $this->layout = $layout;
  }

  public function __toString(): string
  {
    return $this->contentRender();
  }
  

  public function contentRender(): string
  {
    if (isset($this->params)) {
      extract($this->params, EXTR_OVERWRITE);
    }
    ob_start();
    require self::VIEW_PATH_MAP[key($this->template)] . current($this->template) . self::PHP_EXTANSION;

    $content = ob_get_clean();

    if (isset($this->layout)) {
      $layoutPath = self::VIEW_PATH_MAP[key($this->layout)] . current($this->layout) . self::PHP_EXTANSION;
      require $layoutPath;

      $layoutRender = ob_get_clean();

      return $layoutRender;
    }
    return $content;

  }

}