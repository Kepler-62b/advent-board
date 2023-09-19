<?php

declare(strict_types=1);

namespace App;

use Dev\Tests\Services\HydratorServiceLocalTest;
use Dev\Tests\Services\RelationLocalTest;
use Dev\Tests\TestServices;

use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$request = Request::createFromGlobals();
$test = new TestServices();

// $test->testApp($request);

//$modelAdvert = (new HydratorServiceLocalTest())->testHydrateAdvertModel();
//$modelImage = (new HydratorServiceLocalTest())->testHydrateImageModel();
//
//$testRelationAdvertModel = (new RelationLocalTest($modelAdvert))->testRelationInjectionInModel('id');
//var_dump($testRelationAdvertModel);
//$testRelationImageModel = (new RelationLocalTest($modelImage))->testRelationInjectionInModel('itemId');
//var_dump($testRelationImageModel);







