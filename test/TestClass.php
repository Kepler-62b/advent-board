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

$model = new Image();
$model->setId(1)
  ->setName('changed item')
  ->setItemId(50)
;
var_dump($model);
$manager = new ModelManager($model);
var_dump($manager->get());

