<?php

declare(strict_types=1);

namespace App;

use App\Service\PostgresAdvertsBoard;
use Dev\Tests\TestServices;
use App\Service\DependencyContainer;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$test = new TestServices();

$test->testApp();



//phpinfo();