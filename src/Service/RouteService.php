<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

use App\Service\ParseURLService;

class RouteService
{

  private ParseURLService $parseURLobject;

  public function __construct(Request $request)
  {
    $this->parseURLobject = new ParseURLService($request);
  }

  /**
   * @todo разобраться с отрисовкой ответа при использовании виджета-таблицы и без
   * @todo подумать что помещать в requestParams, если параметров нет при Not Found
   */
  public function routingApp(): void
  {
    $matchURL = $this->parseURLobject->matchURL;
    
    $controller = $matchURL['controller'];
    $action = $matchURL['action'];
    $actionParams = $matchURL['action_params'];

    if (empty($queryString)) {
      (new ControllerContainer())->get($controller)->$action();
      // $response->send();
      // var_dump($response);
      // return $response->getContent();
    } else {
      (new ControllerContainer())->get($controller)->$action($actionParams);
      // $response->send();
      // var_dump($response);
      // return $response->getContent();
    }

  }

  public function routingApi(): void
  {
    $matchURL = $this->parseURLobject->matchURL;
    $incomingURL = $matchURL['incomingURL'];
    var_dump($incomingURL);
    $parseURL = $this->parseURLobject->parseRoute($incomingURL);
    // var_dump($parseURL);
    
    // $queryString = $matchURL['queryStringParams'];
    // $controller = $matchURL['controller'];
    // $action = $matchURL['action'];

    // if (empty($queryString)) {
    //   (new ControllerContainer())->get($controller)->$action();
    //   // $response->send();
    //   // var_dump($response);
    //   // return $response->getContent();
    // } else {
    //   (new ControllerContainer())->get($controller)->$action($queryString);
    //   // $response->send();
    //   // var_dump($response);
    //   // return $response->getContent();
    // }

  }






}