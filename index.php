<?php

namespace App;

require 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

use App\Service\RouteService;

$request = Request::createFromGlobals();

$route = new RouteService($request->getPathInfo());
print $route->routing($request)->getContent();