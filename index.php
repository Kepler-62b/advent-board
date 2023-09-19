<?php

declare(strict_types=1);

namespace App;

use App\Repository\AdvertRepository;
use App\Repository\CityRepository;
use App\Service\DependencyContainer;
use Dev\Tests\TestServices;
use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$request = Request::createFromGlobals();
$container = new DependencyContainer();
$test = new TestServices();

// $test->testApp($request);

//$modelAdvert = (new HydratorServiceLocalTest())->testHydrateAdvertModel();
//$modelImage = (new HydratorServiceLocalTest())->testHydrateImageModel();

//$testRelationAdvertModel = (new RelationLocalTest($modelAdvert))->testRelationInjectionInModel('id');
//var_dump($testRelationAdvertModel);
//$testRelationImagetModel = (new RelationLocalTest($modelImage))->testRelationInjectionInModel('itemId');
//var_dump($testRelationImagetModel);

$advertRepository = $container->get(AdvertRepository::class);
var_dump($advertRepository->findById(1));

$cityRepository = $container->get(CityRepository::class);
var_dump($cityRepository->findById(1));








