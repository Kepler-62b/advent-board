<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Response;

class RenderService
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
    $content = require_once "../src/View/content/$templait.php";
    // var_dump($out);
    // return $out;
    return new Response($output);
  }
}