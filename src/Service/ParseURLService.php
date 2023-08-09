<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;


class ParseURLService
{
  private string $fileMap = 'config/route_map.json';
  private string $incomingURL;
  private array $parseURL;

  public function __construct(Request $request)
  {
    $this->incomingURL = $request->getPathInfo();
    $this->parseURL = self::parseURL($request);
  }

  private function parseURL(Request $request)
  {
    $queryString = $request->query->all();
    $routeMap = self::getRouteMap();
    foreach ($routeMap as $uriMap => $routeParamsMap) {
      if ($uriMap === $this->uriRequest) {
        $this->parseURL = [
          'incomingURL' => $uriMap,
          'queryStringParams' => $queryString,
          'controller' => $routeParamsMap['controller'],
          'action' => $routeParamsMap['action'],
        ];
        return $this->parseURL;
      }
    }
    $this->parseURL = [
      'incomingURL' => $this->uriRequest,
      'queryStringParams' => $queryString,
      'controller' => $routeParamsMap['controller'],
      'action' => 'notFound',
    ];
    return $this->parseURL;
  }

  private function getRouteMap(): array
  {
    $fileMap = $this->fileMap;
    $resourse = fopen($fileMap, "r+");
    $routeMap = json_decode(file_get_contents($fileMap), JSON_OBJECT_AS_ARRAY);
    fclose($resourse);
    return $routeMap;
  }
}