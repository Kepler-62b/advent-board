<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class RenderViewService
{
  private LinkRender $linkRender;

  public function __construct()
  {
    $this->linkRender = new LinkRender();
  }

  public function contentRender(string $template, array $rows = null, array $widgets = null): Response
  {
    $linkRender = $this->linkRender;
    ob_start();
    require_once "src/View/templates/$template.php";
    $content = ob_get_clean();
    require_once 'src/View/layout/main.php';
    $layout = ob_get_clean();
    return new Response($layout);
  }

}