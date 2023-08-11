<?php
declare(strict_types=1);

namespace App;

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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Controllers\AdventController;
use App\Controllers\DefaultController;

use App\Service\ControllerContainer;
use App\Service\ParseURLService;
use App\Service\LinkManager;
use App\Service\LinkRender;
use App\Service\RenderViewService;
use App\Service\ServiceContainer;
use App\Service\DatabasePDO;
use App\Service\RouteService;

use App\Repository\AdventRepository;

$request = Request::createFromGlobals();
$db = new DatabasePDO();
$repository = new AdventRepository($db);
$controller = new AdventController($repository);
$linkManager = new LinkManager();
$linkRender = new LinkRender();
$test = new TestService();
$logger = new LoggerService();
$error = new ErrorsGenerator();
$test = new TestService();
$container = new ControllerContainer();

$test->testApp($request);


// print $test->testRouteService($request, 'routingApp');
// $test->testRouteService($request, 'routing');

// $parseURL = $test->testParseURLService($request);
// $parseURL->matchApiURL($request);

// $test->testParseURLService($request, 'parseRoute', '/api/show/{2}');
// $test->testParseURLService($request, 'parseMap');

// print $linkRender->getRootPath('/show/sort/min/', ['page=1',  'price'] );


// $parseURL = new ParseURLService($request);

// var_dump($parseURL);
// var_dump($parseURL->getProp('matchURL'));

// print $test->testTableWithSortWidget($db, $repository, $linkRender);

// print $test->testSortWidget($linkRender);
