<?php

namespace App\Service\Helpers;

use Symfony\Component\HttpFoundation\Request;

class LinkManager
{
  
  public static function link(string $slug = null, array $queryStringParams = null): string
  {
    $request = Request::createFromGlobals();
    if (isset($queryStringParams)) {
      $slug = $slug . '?';
      $queryStringParams = implode('&', $queryStringParams);
    }
    return $request->getBasePath() . $slug . $queryStringParams;
  }

  public static function filter(string $filter)
  {
    $request = Request::createFromGlobals();
    $params = $request->query;
    foreach ($params as $key => $value) {
      if ($key === $filter) {
        $link = "&" . $key . "=" . $value;
        return $link;
      }
    }
  }

  public static function getBasePath(string $path = null, string $var = null): string
  {
    $request = Request::createFromGlobals();
    $link = $request->getBasePath() . $path . $var;
    return $link;
  }
}