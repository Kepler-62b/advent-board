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
   * return the path to the root directory of the project with arguments: slug and query string (optional)
   */
  public function getRootPath(string $slug = null, string $queryParam = null): string
  {
    // $slug = $slug . '?';
    return $this->request->getBasePath() . $slug . $queryParam;
  }

  /**
   * return the path to the root directory of the project AND current route
   */
  public function getPath(): string
  {
    return $this->request->getBasePath() . $this->request->getPathInfo();
  }

  public function getFilter(string $filter)
  {
    $queryString = $this->request->query;
    foreach ($queryString as $param => $value) {
      if ($value === $filter) {
        $filterLink = "&" . $param . "=" . $value;
        return $filterLink;
      }
    }
  }

  public function renderImageLink(string $slug = null, string $imageName = null): string
  {
    return $this->request->getBasePath() . $slug . $imageName;
  }

}