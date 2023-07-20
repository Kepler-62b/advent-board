<?php

namespace App\Service;

use App\Database\DatabasePDO;
use App\Repository\AdventRepository;
use Symfony\Component\HttpFoundation\Response;

class RenderViewService
{
  // public function render(): string
  // {
  //   $filename = "../src/View/layout/main.php";
  //   $resourse = fopen($filename, "r+");
  //   $template = file_get_contents($filename);
  //   fclose($resourse);
  //   return $template;
  // }

  public function contentRender(string $templait, mixed $rows = null, $pagination = null, $navigation = null): Response
  {
    require_once "src/View/content/$templait.php";
    if ($pagination) {}
    require_once 'src/View/layout/main.php';
    return new Response($layout);
  }

  public function paginationRender(AdventRepository $repository): string
  {
    require_once 'src/View/panels/pagination.php';
    return $pagination;
  }

  public function navigationRender(): string
  {
    require_once 'src/View/panels/navigation.php';
    return $navigation;
  }
}