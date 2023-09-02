<?php
declare(strict_types=1);

namespace App;

use App\Models\Advent;
use App\Service\TemplateRenderService;
use App\Service\Widgets\Pagination;
use Dev\Tests\ExtractVarsService;
use Dev\Tests\TemplateNavigation;

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

// print $test->testPagination(27, 5);

// var_dump($test->testNavigationWidget()->renderFromObject());

$navigation = new TemplateNavigation('navigation', 'widgets');
var_dump($navigation);
$content = new TemplateNavigation('create_upload_file', 'content', 'navigation');
var_dump($content);
$layout = new TemplateNavigation('main', 'layouts', 'content');
var_dump($layout);


$render = new RenderViewService(['l' => 'm'], null, ['content' => $content, 'navigation' => $navigation]);
// var_dump($render);
var_dump($render->renderViewFromObject());
// print($render->renderViewFromObject());
// dd($render->renderViewFromObject());

// var_dump($render->renderViewFromObject($content));
// print($render->renderViewFromObject($content));

// print $render->renderViewFromObject();

// var_dump($test->testNavigationWidget());
// var_dump($test->testNavigationWidget()->render());

// var_dump($test->testNavigationWidget()->render()->renderView());
// var_dump($test->testNavigationWidget()->render()->renderViewFromObject(['layouts' => 'main']));

// print $test->testNavigationWidget()->render()->renderView();
// print $test->testNavigationWidget()->render()->renderViewFromObject(['layouts' => 'main']);

// $test->testController($request, $controller, 'create_form');

// $test->testController($request, $controller, str_replace('/', '', $request->getPathInfo()));

// print($test->testControllerCreateMethod($controller, 'create_action'));
