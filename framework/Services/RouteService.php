<?php

namespace Framework\Services;

use Psr\Container\ContainerInterface;

class RouteService
{
    public function __construct(
        private ParseURLService    $parseURL,
        private ContainerInterface $container
    ) {
    }

    /** @TODO подумать что помещать в action_params, если параметров нет при Not Found */
    public function routing(): void
    {
        $matchURL = $this->parseURL->matchURL;

//        dump($matchURL);

        $interface = $matchURL['interface'];
        $controller = $matchURL['controller'];
        $action = $matchURL['action'];
//        $actionParams = $matchURL['action_params'];
        $actionParams = new ActionParams($matchURL['action_params']);

        if (empty($actionParams)) {
            $this->container->get($controller)->$action();
        } else {
            $this->container->get($controller)->$action($actionParams, $interface);
        }
    }
}