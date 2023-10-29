<?php

declare(strict_types=1);

namespace App;

use Framework\Kernel;
use Framework\Services\Database\RedisQueryBuilder;

require dirname(__DIR__).'/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');
// chdir('/app');

return new Kernel(include __DIR__ . '/../config/services.php');
