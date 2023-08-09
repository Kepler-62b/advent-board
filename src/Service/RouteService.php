<?php

namespace App\Service;

use Dev\Logger\LoggerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteService
{

  private string $fileMap = 'config/route_map.json';
  private string $uriRequest;
  private array $parseURL = [];

  public function __construct(Request $request)
  {
    $this->uriRequest = $request->getPathInfo();
    $this->parseURL = self::parseRequest($request);
  }

  /**
   * @todo разобраться с отрисовкой ответа при использовании виджета-таблицы и без
   * @todo подумать что помещать в requestParams, если параметров нет при Not Found
   */
  public function routing()
  {
    $queryString = $this->parseURL['queryStringParams'];
    $controller = $this->parseURL['controller'];
    $action = $this->parseURL['action'];

    if (empty($queryString)) {
      $response = (new ControllerContainer())->get($controller)->$action();
      // $response->send();
      // var_dump($response);
      // return $response->getContent();
    } else {
      $response = (new ControllerContainer())->get($controller)->$action($queryString);
      // $response->send();
      // var_dump($response);
      // return $response->getContent();
    }

  }

  private function getRouteMap(): array
  {
    $fileMap = $this->fileMap;
    $resourse = fopen($fileMap, "r+");
    $routeMap = json_decode(file_get_contents($fileMap), JSON_OBJECT_AS_ARRAY);
    fclose($resourse);
    return $routeMap;
  }

  /**
   * @todo подумать, как использовать поля slug и requestPerems при 404 Not Found
   */
  private function parseRequest(Request $request)
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

  public function parseRoute(string $incomingURL)
  {
    $incomingURL = explode('/', $incomingURL);

    foreach ($incomingURL as $slug) {
      if (str_contains($slug, '{') && str_contains($slug, '}')) {
        return $slug;
      }
    }
    // $route = strtr($route, $replace);
    return $incomingURL;
  }


  public function getProp()
  {
    return $this->parseURL;
  }


}