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

  /**
   * return the path to the root directory of the project (without arguments)
   */
  public function getRootPath(string $route = null, string $var = null): string
  {
    return $this->request->getBasePath() . $route . $var;
  }

  /**
   * return the path to the root directory of the project AND current route
   */
  public function getPath(): string
  {
    return $this->request->getBasePath() . $this->request->getPathInfo();
  }

  public function sort(string $filter)
  {
    $params = $this->request->query;
    foreach ($params as $key => $value) {
      if ($value === $filter) {
        $link = "&" . $key . "=" . $value;
        return $link;
      }
    }
  }

  // public function render()
  // {
  //   if (str_contains($this->getPath(), "min")) {
  //     return "▲";
  //   } elseif (str_contains($this->getPath(), "max")) {
  //     return "▼";
  //   }
  // }

}