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
    require_once "src/View/content/$content.php";
    require_once 'src/View/layout/main.php';
    return new Response($layout);
  }

}