<?php

namespace App;

require 'vendor/autoload.php';

use App\Service\TableWidget;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Controllers\AdventController;

use App\Service\LinkManager;
use App\Service\LinkRender;
use App\Service\RenderViewService;
use App\Service\ServiceContainer;
use App\Service\WidgetRender;


use App\Service\DatabasePDO;
use App\Repository\AdventRepository;
use App\Service\RouteService;

$request = Request::createFromGlobals();
$db = new DatabasePDO();
$repository = new AdventRepository($db);
$linkManager = new LinkManager();
$linkRender = new LinkRender();

// тест работы всего приложения
$route = new RouteService($request->getPathInfo());
print $route->routing($request)->getContent();
// тест работы всего приложения

// тест таблицы

// $table = new TableWidget($repository->getAllRows(2));
// $table = $table->setColumns(['id', 'item', 'description', 'price', 'image'])->render();
// TableWidget::renderWidget($table);

// тест таблицы

//  тест контроллера
// $controller = new AdventController($repository);
// var_dump(get_class_methods($controller));
// echo $controller->showById(['id' => '1']);

//  тест контроллера

// тест панели навигации
// WidgetRender::renderWidget('navigation');
// тест панели навигации

// тест панели пагинации
// WidgetRender::renderWidget('pagination');
// тест панели пагинации

// тестирование контейнера
// $container = new ServiceContainer();
// var_dump($container->get(LinkRender::class));
// $linkRender = $container->get(LinkRender::class);
// var_dump($linkRender->getPath());
// тестирование контейнера

// тест разного
// var_dump(AdventController::class);

// var_dump($request->getBasePath());
// var_dump($_SERVER);
// var_dump(implode('&', $request->query->all()));
// var_dump($request->query->all());
// var_dump(http_build_query($request->query->all()));
