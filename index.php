<?php
declare(strict_types=1);

namespace App;

require 'vendor/autoload.php';

use App\Service\Widgets\SortWidget;
use App\Service\Widgets\TableWidget;
use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\PaginationWidget;
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

function testWidgets(DatabasePDO $db, AdventRepository $repository, LinkRender $linkRender)
{
  $sort = new SortWidget($linkRender);
  $sortPrice = $sort
    ->setParams(
      [
        'columnName' => 'Price',
        'filter' => 'price'
      ]
    );
  $sortDate = $sort
    ->setParams(
      [
        'columnName' => 'Date',
        'filter' => 'create_date'
      ]
    );

  $table = new TableWidget($linkRender);
  $table->setParams([
    'rows' => $repository->getAllRows(2),
    'columns' => [
      'id' => 'Id',
      'item' => 'Item',
      'description' => 'Description',
      'price' => $sortPrice,
      'image' => 'Image',
      'created_date' => $sortDate
    ]
  ]);

  // return $table->render();
  return $table;
}

function testSortWidget(LinkRender $linkRender)
{
  $sort = new SortWidget($linkRender);
  $sortPrice = $sort
    ->setParams(
      [
        'columnName' => 'Price',
        'filter' => 'price'
      ]
    )->render();
  return $sortPrice;
}

// echo ((testWidgets($db, $repository, $linkRender)));

// тест виджета-сортировки
// $sort = new SortWidget($linkRender);
// $sort->setFilter('price');
// $sort->setParams('Price', 'price');
// var_dump($sort->render());
// тест виджета-сортировки

// тест отрисовки ссылок с помощью сервиса RenderViewContent

// $navigation = new NavigationWidget($linkRender);
// $pagination = new PaginationWidget($linkRender);
// $sort = new SortWidget($linkRender);
// $sortPrice = $sort
//   ->setParams([
//     'columnName' => 'Price',
//     'filter' => 'price'
//   ])->render();
// $sortDate = $sort
//   ->setParams([
//     'columnName' => 'Date',
//     'filter' => 'create_date'
//   ])->render();
// $table = new TableWidget($linkRender);
// $table->setParams([
//   'rows' => $repository->getAllRows(2),
//   'columns' => [
//     'id' => 'Id',
//     'item' => 'Item',
//     'description' => 'Description',
//     'price' => $sortPrice,
//     'image' => 'Image',
//     'created_date' => $sortDate
//   ]
// ]);

// $render = new RenderViewService();
// print $render->contentRender('show_widgets', null, [
//   'table' => $table,
//   'link' => $linkRender,
//   'navigation' => $navigation,
//   'pagination' => $pagination
// ]);

// тест отрисовки ссылок с помощью сервиса RenderViewContent

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
