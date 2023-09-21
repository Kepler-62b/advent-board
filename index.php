<?php

declare(strict_types=1);

namespace App;

use App\Models\Image;
use App\Service\OneToManyRelation;
use App\Service\Relation;
use Dev\Tests\TestServices;
use App\Service\DependencyContainer;
use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$request = Request::createFromGlobals();
$container = new DependencyContainer();
$test = new TestServices();

// $test->testApp($request);


$image = new Image(1, 'name', 65);

$relation = new Relation($image);
var_dump($relation);
$relation->getRelation('itemId');
var_dump($relation);










