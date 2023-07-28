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

  public function contentRender(string $content, mixed $rows = null): Response
  {
    $linkRender = $this->linkRender;
    ob_start();
    require_once "src/View/content/$content.php";
    $content = ob_get_clean();
    require_once 'src/View/layout/main.php';
    $layout = ob_get_clean();
    return new Response($layout);
  }

}