<?php
declare(strict_types=1);

namespace App;

use App\Models\Advent;
use App\Service\TemplateRenderService;
use App\Service\Widgets\Pagination;
use Dev\Tests\ExtractVarsService;

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
// $model = new Advent();
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

$test->testApp($request);

// $date = new \DateTimeImmutable();
// var_dump($date->setDate(2000,9,21));
// var_dump($date);

// var_dump(str_replace('/', '', $request->getPathInfo()));
// $test->testController($request, $controller, str_replace('/', '', $request->getPathInfo()));


// print($test->testControllerCreateMethod($controller, 'create_action'));
// var_dump($request);
// var_dump($request->request);
// var_dump($request->getPathInfo());
// var_dump(str_replace('/', '', $request->getPathInfo()));


// var_dump($test->testRepository($db, 'save'));
