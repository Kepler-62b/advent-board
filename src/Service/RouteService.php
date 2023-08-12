<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

use App\Service\ParseURLService;

class RouteService
{

  private ParseURLService $parseURL;

  public function __construct(Request $request)
  {
    $this->parseURL = new ParseURLService($request);
  }

  /**
   * @todo разобраться с отрисовкой ответа при использовании виджета-таблицы и без
   * @todo подумать что помещать в action_params, если параметров нет при Not Found
   */
  public function routing(): void
  {
    $matchURL = $this->parseURL->matchURL;

    $interface = $matchURL['interface'];
    $controller = $matchURL['controller'];
    $action = $matchURL['action'];
    $actionParams = $matchURL['action_params'];

    if (empty($actionParams)) {
      (new ControllerContainer())->get($controller)->$action();
      // return $response->getContent();
    } else {
      (new ControllerContainer())->get($controller)->$action($actionParams, $interface);
      // return $response->getContent();
    }

  }






}