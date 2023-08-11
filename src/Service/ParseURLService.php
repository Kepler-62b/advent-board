<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;


class ParseURLService
{
  private const APP_MAP = 'config/app_route_map.json';
  private const API_MAP = 'config/api_route_map.json';
  private array $parseURL = [];
  public array $matchURL;


  public function __construct(Request $request)
  {
    $this->matchURL = self::matchURL($request);
  }

  /**
   * @todo подумать, как использовать поля slug и requestPerems при 404 Not Found
   */
  private function matchURL(Request $request): array
  {
    $incomingURL = $request->getPathInfo();
    $queryString = $request->query->all();
    $routeMap = self::getRouteMap($this::APP_MAP);

    foreach ($routeMap as $uriMap => $routeParamsMap) {
      if ($uriMap === $incomingURL) {
        $this->matchURL = [
          'incomingURL' => $uriMap,
          'controller' => $routeParamsMap['controller'],
          'action' => $routeParamsMap['action'],
          'action_params' => $queryString,
        ];
        return $this->matchURL;
      }
    }

    $this->matchURL = [
      'incomingURL' => $incomingURL,
      'queryStringParams' => $queryString,
      'controller' => $routeParamsMap['controller'],
      'action' => 'notFound',
    ];

    return $this->matchURL;
  }

  private function getRouteMap(string $fileMap = null): array
  {
    // $fileMap = $this->fileMap;
    $resourse = fopen($fileMap, "r+");
    $routeMap = json_decode(file_get_contents($fileMap), JSON_OBJECT_AS_ARRAY);
    fclose($resourse);
    return $routeMap;
  }

  public function getProp(string $prop): mixed
  {
    return $this->$prop;
  }

  public function parseRoute(string $incomingURL)
  {
    preg_match_all("/{(\w*)}/", $incomingURL, $matches, PREG_PATTERN_ORDER);

    $this->parseURL = $matches;

    return $this->parseURL;
  }

  /**
   * @todo обрабатывать несуществующие роуты, приходящие на API
   */
  public function matchApiURL(Request $request)
  {
    $incomingURL = $request->getPathInfo();
    var_dump($incomingURL);
    $routeMap = self::getRouteMap($this::API_MAP);
    var_dump($routeMap);

    foreach ($routeMap as $urlMap => $routeParamsMap) {
      if (preg_split("/\d+/", $incomingURL) === preg_split("/{(\w*)}/", $urlMap)) {
        // echo 'step 1';
        if (count(preg_split("/\/\w*/", $incomingURL)) === count(preg_split("/\/\w*/", $urlMap)))
          // echo 'step 2';
        $this->matchURL = [
          'incomingURL' => $incomingURL,
          'controller' => $routeParamsMap['controller'],
          'action' => $routeParamsMap['action'],
          'action_params' => preg_replace("/\/\D*/", '', $incomingURL),
        ];
        var_dump($this->matchURL);
        // return $this->matchURL;
      }
    }

    // var_dump(preg_replace("/\/\D*/", '', $incomingURL));
  }


}