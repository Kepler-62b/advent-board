<?php

namespace App\Service;

class RenderViewService
{

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

  public function exceptionContent(string $template)
  {
    if(isset($this->data)) {
      extract($this->data, EXTR_OVERWRITE);
    }

    // $widgets = $this->widgets;

    ob_start();
    require_once "src/View/exception/$template.php";
    $content = ob_get_clean();
    require_once 'src/View/layout/main.php';
    $renderPage = ob_get_clean();
    return $renderPage;
  }

}