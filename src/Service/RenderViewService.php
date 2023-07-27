<?php

namespace App\Service;

use App\Repository\AdventRepository;
use App\Service\ServiceContainer;
use App\Service\WidgetRender;
use Symfony\Component\HttpFoundation\Response;

class RenderViewService
{
  private LinkRender $linkRender;

  public function __construct()
  {
    $this->linkRender = new LinkRender();
  }

  // public function render(): string
  // {
  //   $filename = "../src/View/layout/main.php";
  //   $resourse = fopen($filename, "r+");
  //   $template = file_get_contents($filename);
  //   fclose($resourse);
  //   return $template;
  // }

  public function contentRender(string $content, mixed $rows = null): Response
  {
    $linkRender = $this->linkRender;
    require_once "src/View/content/$content.php";
    require_once 'src/View/layout/main.php';
    return new Response($layout);
  }

}