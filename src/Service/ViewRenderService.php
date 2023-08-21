<?php

namespace App\Service;

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

  private array $viewTemplate;

  private ?array $layout = [];

  private ?array $params = [];

  public function __construct(array $viewTemplate, array $layout = null, array $params = null)
  {
    $this->viewTemplate = $viewTemplate;
    $this->params = $params;
    $this->layout = $layout;
  }

  public function __toString(): string
  {
    // return $this->templateRender();
    return $this->contentRender();
  }

  /**
   * @deprecated не использовать
   */
  public function templateRender(): string
  {
    $template = current($this->template);

    if (isset($this->params)) {
      extract($this->params, EXTR_OVERWRITE);
    }

    ob_start();

    require "src/View/widgets/$template.php";


    $content = ob_get_clean();

    // $content = ob_get_contents();
    // ob_end_clean();

    return $content;
  }
  

  public function contentRender(): string
  {
    if (isset($this->params)) {
      extract($this->params, EXTR_OVERWRITE);
    }
    ob_start();
    require self::VIEW_PATH_MAP[key($this->viewTemplate)] . current($this->viewTemplate) . self::PHP_EXTANSION;

    // @TODO изменить имя переменной $content и все зависимые от нее методы
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