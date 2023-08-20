<?php

namespace App\Service;

class RenderViewService
{
  private const PHP_EXTANSION = '.php';
  private const EXCEPTION_PATH = 'src/View/exception';
  private const LAYOUT_PATH = 'src/View/layout';
  private const TEMPLATE_PATH = 'src/View/template';

  // @TODO подумать, как объеденить с методом TempleteRenderService
  private ?array $data = [];
  private ?array $widgets = [];

  public function __construct(array $data = null, array $widgets = null)
  {
    $this->data = $data;
    $this->widgets = $widgets;
  }

  /**
   * @todo разобраться, как работает метод contentRender при использовании виджета-таблицы и без использования
   * @todo переименовать аргумент rows - могут быть переданны любые данные, не только строки
   * 
   */
  public function contentRender(string $template): string
  {
    $data = $this->data;
    $widgets = $this->widgets;

    ob_start();
    require_once "src/View/templates/$template.php";
    $content = ob_get_clean();
    require_once 'src/View/layout/main.php';
    $renderPage = ob_get_clean();
    return $renderPage;
  }

  public function exceptionRender(string $template, string $layout = null)
  {

    if (isset($this->data)) {
      extract($this->data, EXTR_OVERWRITE);
    }

    $templatePath = self::EXCEPTION_PATH . '/' . $template . self::PHP_EXTANSION;

    ob_start();

    require_once $templatePath;

    // @TODO изменить имя переменной $content и все зависимые от нее методы
    $content = ob_get_clean();

    // $content = ob_get_contents();
    // ob_end_clean();

    if (isset($layout)) {
      $layoutPath = self::LAYOUT_PATH . '/' . $layout . self::PHP_EXTANSION;
      require_once $layoutPath;

      $layoutRender = ob_get_clean();

      // $layoutRender = ob_get_contents();
      // ob_end_clean();

      return $layoutRender;
    }
    return $content;
  }

}