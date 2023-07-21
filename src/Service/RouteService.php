<?php

namespace App\Service;

class RouteService
{

  public function __construct(
    private string $path
  ) {
  }

  public function routing($param = null)
  {
    if (!isset($param)) {
    }

    $map = $this->getRouteMap();
    foreach ($map as $path => $value) {
      if ($path === $this->path) {
        $className = $value['controller'];
        $action = $value['action'];
        return (new ControllerContainer())->get($className)->$action($param);
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