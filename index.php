<?php

declare(strict_types=1);

namespace App;

use App\Service\DatabaseConnection;
use Dev\Tests\TestServices;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$test = new TestServices();

$test->testApp();
//$test->testDatabaseConnection();

//phpinfo();