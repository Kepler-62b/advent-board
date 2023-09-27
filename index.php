<?php

declare(strict_types=1);

namespace App;

use App\Service\Helpers\LinkManager;
use Dev\Service\TestStaticClass;
use Dev\Tests\TestServices;
use App\Service\DependencyContainer;
use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$request = Request::createFromGlobals();
$link = new LinkManager($request);
$container = new DependencyContainer();
$test = new TestServices();

// $test->testApp($request);

$user = "root";
$pass = "";
$dsn = "mysql:host=localhost;port=3306;dbname=php_advent_board;charset=utf8";

$pdo = new \PDO($dsn, $user, $pass);
dd($pdo);
// phpinfo();
