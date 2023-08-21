<?php
declare(strict_types=1);

namespace App;

use App\Models\Advent;
use App\Service\TemplateRenderService;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use Dev\Tests\PerfomanceTestService;
use Dev\Logger\ErrorsGenerator;
use Dev\Logger\LoggerService;
use Dev\Tests\TestService;

use App\Service\Widgets\SortWidget;
use App\Service\Widgets\TableWidget;
use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\PaginationWidget;

use App\Service\Helpers\LinkManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Controllers\AdventController;
use App\Controllers\DefaultController;

use App\Service\ControllerContainer;
use App\Service\ParseURLService;
use App\Service\LinkRender;
use App\Service\RenderViewService;
use App\Service\ServiceContainer;
use App\Service\DatabasePDO;
use App\Service\RouteService;

use App\Repository\AdventRepository;

$request = Request::createFromGlobals();
$model = new Advent();
$db = new DatabasePDO();
$repository = new AdventRepository($db);
$controller = new AdventController($repository);
$linkManager = new LinkManager($request);
$linkRender = new LinkRender();
$test = new TestService();
$logger = new LoggerService();
$error = new ErrorsGenerator();
$test = new TestService();
$container = new ControllerContainer();

// $test->testApp($request);

// print $test->testViewRenderService(['widget' => 'navigation'], ['layout' => 'main']);
// $test->testRenderViewService(['widgets' => 'navigation'])->render();
// print $test->testRenderViewService(['widgets' => 'navigation']);
// var_dump( $test->testRenderViewService(['widgets' => 'navigation']));
// print $test->testRenderViewService(['widgets' => 'pagination'], ['count' => 5]);
// var_dump($test->testRenderViewService(['widgets' => 'pagination'], ['count' => 5]));

// print $test->testRenderViewService(
//   ['layouts' => 'main'],
//   [
//     'content' => $test->testRenderViewService(
//       ['content' => 'create'],
//       [
//         'navigation' =>
//         $test->testRenderViewService(['widgets' => 'navigation'])->render()
//       ]
//     )
//   ]
// );


$navigation = $test->testRenderViewService(['widgets' => 'navigation'])->renderView();
// $pagination = $test->testRenderViewService(
//   null,
//   [
//     'widgets' => 'pagination',
//     'count' => 5
//   ]
// )->renderView();
// var_dump($navigation);
// var_dump($pagination);
$content = $test->testRenderViewService(
  ['content' => 'create'],
  [
    'navigation' => $navigation,
  ]
)->renderView();
// dd($content);
// print($content);

// $content = $test->testRenderViewService([
//   'content' => 'create',
//   'navigation' => $navigation,
// ])->renderView();

$renderView = $test->testRenderViewService(
  ['layouts' => 'main'],
  [
    'content' => $content,
    'navigation' => $navigation,
  ]
);
print $renderView;




// $model->setId(1);
// $closure = fn(Advent $advent): int => $advent->getId();
// print $closure($model);

// $test->testController($request, $controller, 'showAll');

// var_dump($test->testSortWidget('Price')->render());
// print $test->testSortWidget('Date');

// print $test->testTableWidget($repository)->render();
// print $test->testNavigationWidget()->render();
// print $test->testPaginationWidget()->render();

// print $linkManager::link('/', null, ['filter']);
// print new TemplateRenderService('sort', ['columnName' => 'Price', 'filter' => 'price']);
// print new TemplateRenderService('navigation');

// var_dump((new TemplateRenderService('pagination', ['count' => 5]))->contentRender());
// var_dump((new TemplateRenderService('pagination', ['count' => 5]))->contentRender());
// print new TemplateRenderService('pagination', ['count' => 5]);
echo "<br>";


// var_dump($GLOBALS);
// var_dump($GLOBALS['_SERVER']['REQUEST_URI']);
