<?php

declare(strict_types=1);

namespace App;

use Framework\Kernel;

require dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');
//chdir('/app');

return new Kernel();
