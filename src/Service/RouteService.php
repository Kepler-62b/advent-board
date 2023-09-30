<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

use App\Service\ParseURLService;

class RouteService
{
    private ParseURLService $parseURL;

    public function __construct(ParseURLService $parseURL)
    {
        $this->parseURL = $parseURL;
    }

    /** @TODO подумать что помещать в action_params, если параметров нет при Not Found */
    public function routing(): void
    {
        $matchURL = $this->parseURL->matchURL;

        var_dump($matchURL);

        $interface = $matchURL['interface'];
        $controller = $matchURL['controller'];
        $action = $matchURL['action'];
        $actionParams = $matchURL['action_params'];

        if (empty($actionParams)) {
//            var_dump((new DependencyContainer())->get($controller));
            (new DependencyContainer())->get($controller)->$action();
        } else {
            (new DependencyContainer())->get($controller)->$action($actionParams, $interface);
        }
    }
}