<?php

namespace App\Test;

require '../vendor/autoload.php';

use App\Controllers\AdventController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use App\Database\DatabasePDO;
use App\Models\Advent;
use App\Models\Image;

use App\Repository\AdventRepository;
use App\Repository\ImageRepository;

use App\Service\ModelManager;

$db = new DatabasePDO();
$repo = new AdventRepository($db);

$controller = new AdventController();
$content = $controller->create();
print $content->getContent();
// var_dump($content->getContent());
