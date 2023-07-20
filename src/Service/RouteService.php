<?php

namespace App\Service;

use App\Controllers\AdventController;
use App\Repository\AdventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteService
{

  public function __construct(
    private string $path
  ) {
  }

  public function routing($param = null)
  {
    $map = $this->getRouteMap();
    var_dump($map);
    foreach ($map as $path => $value) {
      if ($path === $this->path) {
        var_dump($value);
        $classname = $value['controller'];
        $action = $value['action'];
        $controller = (new $classname())->$action($param);
      }
    }
    print $controller->getContent();
  }

  public function getRouteMap(): array
  {
    $filename = "config/route_map.json";
    $resourse = fopen($filename, "r+");
    $map = json_decode(file_get_contents($filename), JSON_OBJECT_AS_ARRAY);
    fclose($resourse);
    return $map;
  }


}