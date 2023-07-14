<?php

namespace App;

require 'vendor/autoload.php';

use App\Controllers\ShowController;
use App\Controllers\SortController;
use App\Controllers\AddController;
use App\Controllers\ValidationController;

$show = new ShowController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['QUERY_STRING'] === '') {
  $rows = $show->showRows(1);

  require_once __DIR__ . "\src\View\show.php";
  require_once __DIR__ . "\src\View\layout\pagination.php";
  require_once __DIR__ . "\src\View\layout\\navigation.php";
} 
elseif (isset($_GET['id']) || isset($_GET["fields"])) {
  $rows = $show->showRow($_GET['id']);
  $row = $rows[0];
  $images = $show->showImages($_GET['id']);

  require_once __DIR__ . "\src\View\get.php";
  require_once __DIR__ . "\src\View\layout\\navigation.php";
} elseif (isset($_GET['sort'])) {
  $sort = ((new SortController())->createSort($_GET['sort']));
  $rows = ((new ShowController())->showEmptyRows($sort, $_GET));
  require_once __DIR__ . "\src\View\show.php";
  require_once __DIR__ . "\src\View\layout\pagination.php";
  require_once __DIR__ . "\src\View\layout\\navigation.php";
} elseif (isset($_GET['page'])) {
  echo 'hello';
  $sort = ((new SortController())->getSort());
  $rows = ((new ShowController())->showEmptyRows($sort, $_GET));

  require_once __DIR__ . "\src\View\show.php";
  require_once __DIR__ . "\src\View\layout\pagination.php";
  require_once __DIR__ . "\src\View\layout\\navigation.php";
} elseif (isset($_FILES['userfile']) && isset($_POST['id'])) {
  $file = ((new AddController())->addFile());
  $update = ((new AddController()))->updateImage($_POST['id'], $_FILES['userfile']['name']);
  $rows = $show->showRow($_POST['id']);
  $row = $rows[0];
  $images = $show->showImages($_POST['id']);

  require_once __DIR__ . "\src\View\get.php";
  require_once __DIR__ . "\src\View\layout\\navigation.php";
} elseif (isset($_FILES['userfile'])) {
  // сделать класс валидации, который обрабатывает массив POST параметров
  $file = ((new AddController())->addFile());
  $item = ((new ValidationController())->lessValidation($_POST['item'], 200));
  $description = ((new ValidationController())->lessValidation($_POST['description'], 3000));
  $create_row = (new AddController())->addRow($item, $description, $_POST['price'], $file);
  $rows = $show->showRows(1);
  require_once __DIR__ . "\src\View\show.php";
  require_once __DIR__ . "\src\View\layout\\navigation.php";
}

// var_dump($_SERVER);
// var_dump($_SERVER['QUERY_STRING']);

// var_dump($_GET);
// var_dump($_POST);
// var_dump($_FILES);



