<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class ParseURLService
{
  private const APP_MAP = 'config/app_route_map.json';
  private const API_MAP = 'config/api_route_map.json';
  public array $matchURL;
  private array $parseURL = [];


  public function __construct(Request $request)
  {
    if (str_contains($request->getPathInfo(), 'api')) {
      $this->matchURL = self::matchApiURL($request);
    } else {
      $this->matchURL = self::matchAppURL($request);
    }
  }

  private function getRouteMap(string $fileMap): array
  {
    $resourse = fopen($fileMap, "r+");
    $routeMap = json_decode(file_get_contents($fileMap), JSON_OBJECT_AS_ARRAY);
    fclose($resourse);
    return $routeMap;
  }

  /**
   * @todo подумать, как использовать поля slug и requestPerems при 404 Not Found
   */
  private function matchAppURL(Request $request): array
  {
    $incomingURL = $request->getPathInfo();
    $queryString = $request->query->all();
    $routeMap = self::getRouteMap($this::APP_MAP);

    foreach ($routeMap as $uriMap => $routeParamsMap) {
      if ($uriMap === $incomingURL) {
        $this->matchURL = [
          'interface' => null,
          'incomingURL' => $uriMap,
          'controller' => $routeParamsMap['controller'],
          'action' => $routeParamsMap['action'],
          'action_params' => $queryString,
        ];
        var_dump($this->matchURL);
        return $this->matchURL;
      }
    }

    $this->matchURL = [
      'incomingURL' => $incomingURL,
      'controller' => $routeParamsMap['controller'],
      'action' => 'notFound',
      'action_params' => $queryString,
    ];

    return $this->matchURL;
  }

  /**
   * @todo обрабатывать несуществующие роуты, приходящие c префиксом /api
   * @todo обрабатывать несколько параметров для экшена из URL
   */
  public function matchApiURL(Request $request)
  {
    $incomingURL = $request->getPathInfo();
    $routeMap = self::getRouteMap($this::API_MAP);

    foreach ($routeMap as $urlMap => $routeParamsMap) {
      if (preg_split("/\d+/", $incomingURL) === preg_split("/{(\w*)}/", $urlMap)) {
        if (count(preg_split("/\/\w*/", $incomingURL)) === count(preg_split("/\/\w*/", $urlMap)))
          $this->matchURL = [
            'interface' => 'api',
            'incomingURL' => $incomingURL,
            'controller' => $routeParamsMap['controller'],
            'action' => $routeParamsMap['action'],
            'action_params' => [
              $routeParamsMap['action_params'] => preg_replace("/\/\D*/", '', $incomingURL)
            ],
          ];

          // var_dump($this->matchURL);
        return $this->matchURL;
      }
    }
  }

  public function parseRoute(string $incomingURL)
  {
    preg_match_all("/{(\w*)}/", $incomingURL, $matches, PREG_PATTERN_ORDER);

    $this->parseURL = $matches;

    return $this->parseURL;
  }





}