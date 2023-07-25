<?php

namespace App;

require 'vendor/autoload.php';

use App\Service\LinkManager;
use App\Service\RenderViewService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\DatabasePDO;
use App\Repository\AdventRepository;
use App\Service\RouteService;

$request = Request::createFromGlobals();
$db = new DatabasePDO();
$repository = new AdventRepository($db);
$linkManager = new LinkManager($request);


$route = new RouteService($request->getPathInfo());
print $route->routing($request)->getContent();

// тест панели навигации
// $navigation = new RenderViewService();
// $content = $navigation->navigationRender($linkManager);
// print (new Response($content))->getContent();
// тест панели навигации

// тест панели пагинации
// $pagination = new RenderViewService($linkManager);
// $content = $pagination->paginationRender($repository);
// print (new Response($content))->getContent();
// тест панели пагинации

// var_dump($request->getBasePath());
// var_dump($_SERVER);
// var_dump(implode('&', $request->query->all()));
// var_dump($request->query->all());
// var_dump(http_build_query($request->query->all()));

