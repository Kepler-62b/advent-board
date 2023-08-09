<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class RenderViewService
{
  private LinkRender $linkRender;

  public function __construct(LinkRender $linkRender)
  {
    $this->linkRender = $linkRender;
  }

  /**
   * @todo разобраться, как работает метод contentRender при использовании виджета-таблицы и без использования
   * @todo переименовать аргумент rows - могут быть переданны любые данные, не только строки
   * 
   * @return string
   */
  public function contentRender(string $template, array $rows = null, array $widgets = null): string
  {
    $linkRender = $this->linkRender;
    ob_start();
    require_once "src/View/templates/$template.php";
    $content = ob_get_clean();
    require_once 'src/View/layout/main.php';
    $renderPage = ob_get_clean();
    return $renderPage;
  }

}