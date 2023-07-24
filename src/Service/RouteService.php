<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class RouteService
{

  public function __construct(
    private string $path
  ) {
  }

  public function routing(Request $request)
  {
    $param = $request->query->all();
    $map = $this->getRouteMap();
    foreach ($map as $path => $value) {
      if ($path === $this->path) {
        $controller = $value['controller'];
        $action = $value['action'];
        if (empty($param)) {
          return (new ControllerContainer())->get($controller)->$action();
        } else {
          return (new ControllerContainer())->get($controller)->$action($param);
        }
      }
    }
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