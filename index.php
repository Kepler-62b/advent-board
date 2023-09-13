<?php

declare(strict_types=1);

namespace App;

use App\Models\Advert;
use App\Models\Image;
use App\Service\RenderTemplateServise;
use App\Service\TemplateNavigator;
use App\Service\Widgets\Pagination;
use App\Models\Advent;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use Dev\Tests\PerfomanceTestService;
use Dev\Logger\ErrorsGenerator;
use Dev\Logger\LoggerService;
use Dev\Tests\Services\HydratorServiceLocalTest;
use Dev\Tests\TestServices;

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
use App\Service\PDOMySQL;
use App\Service\RouteService;

use App\Repository\AdventRepository;

$request = Request::createFromGlobals();
$model = new Advent();
$db = new PDOMySQL();
$repository = new AdventRepository($db);
$controller = new AdventController($repository);
$linkManager = new LinkManager($request);
$linkRender = new LinkRender();
$test = new TestServices();
$logger = new LoggerService();
$error = new ErrorsGenerator();
$test = new TestServices();
$container = new ControllerContainer();

// $test->testApp($request);

  $testHydrator = new HydratorServiceLocalTest();
//  $testHydrator->testHydrateAdvertModel();
  $testHydrator->testHydrateImageModel();
