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
    // var_dump($params);
    foreach ($params as $key => $value) {
      if ($key === 'filter') {
        $link = "&" . $key . "=" . $value;
        // var_dump($link);
        print $link;
      }
    }
    // if($this->request->query->has('filter')) {
    //   var_dump($this->request->query->keys());
    //   var_dump($this->request->query->get('filter'));
    // }
  }

  public function getBasePath(string $path = null, string $var = null): void
  {
    $link = $this->request->getBasePath() . $path . $var;
    print $link;
  }

}