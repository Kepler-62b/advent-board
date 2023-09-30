<?php

declare(strict_types=1);

namespace App;

use App\Service\Helpers\LinkManager;
use Dev\Tests\TestServices;
use App\Service\DependencyContainer;
use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$test = new TestServices();

$test->testApp();