<?php

namespace App\Service;

use App\Repository\AdventRepository;
use App\Service\ServiceContainer;
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

  public function contentRender(string $template, mixed $rows = null, $pagination = null, $navigation = null): Response
  {
    $linkRender = $this->linkRender;
    require_once "src/View/content/$template.php";
    if ($pagination) {
    }
    require_once 'src/View/layout/main.php';
    return new Response($layout);
  }

  public function paginationRender(AdventRepository $repository): string
  {
    $linkRender = $this->linkRender;
    require_once 'src/View/panels/pagination.php';
    return $pagination;
  }

  public function navigationRender(): string
  {
    $linkRender = $this->linkRender;
    require_once 'src/View/panels/navigation.php';
    return $navigation;
  }


}