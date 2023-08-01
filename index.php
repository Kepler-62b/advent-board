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

$route = new RouteService($request->getPathInfo());
print $route->routing($request)->getContent();