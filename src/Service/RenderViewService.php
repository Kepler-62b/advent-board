<?php

namespace App\Service;

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

  public function contentRender(string $templait, mixed $rows = null): Response
  {
    require_once "../src/View/content/$templait.php";
    // require_once "../src/View/panels/pagination.php";
    require_once "../src/View/panels/navigation.php";
    require_once "../src/View/layout/main.php";

    // var_dump($out);
    // return $out;
    return new Response($layout);
  }

}