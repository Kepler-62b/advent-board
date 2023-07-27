<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class LinkManager
{

  public static function getPath()
  {
    $path = parse_url($_SERVER['REQUEST_URI']);
    echo $path['path'];
  }
  public static function getQuery()
  {
    $request = Request::createFromGlobals();
    $params = $request->query;
    foreach ($params as $key => $value) {
      if ($key === 'filter') {
        $link = "&" . $key . "=" . $value;
        echo $link;
      }
    }
  }

  public static function getBasePath(string $path = null, string $var = null): void
  {
    $request = Request::createFromGlobals();
    $link = $request->getBasePath() . $path . $var;
    echo $link;
  }
}