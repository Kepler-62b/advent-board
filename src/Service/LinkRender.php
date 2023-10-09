<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class LinkRender
{
  const DEFAULT_PARAM = 'page=1';
  const IMAGE_DIR = '/public/img/user/';
  private $request;

  public function __construct()
  {
    $this->request = Request::createFromGlobals();
  }

  /**
   * return the path to the root directory of the project with arguments (optional): slug and query string
   */
  public function getRootPath(string $slug = null, array $queryStringParams = null): string
  {
    if (isset($queryStringParams)) {
      $slug = $slug . '?';
      $queryStringParams = implode('&', $queryStringParams);
    }
    return $this->request->getBasePath() . $slug . $queryStringParams;
  }

  /**
   * return the path to the root directory of the project AND incoming URL
   */
  public function getPath(): string
  {
    return $this->request->getBasePath() . $this->request->getPathInfo();
  }

  /**
   * @todo предусматреть возращаемое значение в случае не нахождения ключа
   */
  public function getFilter(string $filter)
  {
    $queryString = $this->request->query;
    foreach ($queryString as $param => $value) {
      if ($value === $filter) {
        $filterLink = '&' . $param . "=" . $value;
        return $filterLink;
      }
    }
  }

  public function renderImageLink(string $imageName = null): string
  {
    return $this->request->getBasePath() . $this::IMAGE_DIR . $imageName;
  }

}