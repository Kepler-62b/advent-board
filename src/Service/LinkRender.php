<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class LinkRender
{

  private $request;

  public function __construct()
  {
    $this->request = Request::createFromGlobals();
  }

  public function getPath()
  {
    $path = parse_url($_SERVER['REQUEST_URI']);
    return $path['path'];
  }
  public function getQuery()
  {
    $params = $this->request->query;
    foreach ($params as $key => $value) {
      if ($key === 'filter') {
        $link = "&" . $key . "=" . $value;
        echo $link;
      }
    }
  }

  public function getBasePath(string $path = null, string $var = null): void
  {
    $link = $this->request->getBasePath() . $path . $var;
    echo $link;
  }

}