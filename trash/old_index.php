<?php

require_once __DIR__ . "\src\Models\PdoConnection.php";
require_once __DIR__ . "\src\Controllers\ShowController.php";

// var_dump($_SERVER);
// var_dump($_SERVER['QUERY_STRING']);
// var_dump($_GET);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['QUERY_STRING'] === '') {
  $rows = ((new ShowController())->showRows(1));
  require_once __DIR__ . "\src\View\show.php";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $create_row = (new CreateController())->createRow($_POST['item'], $_POST['description'], $_POST['price'], $_POST['image']);
  $rows = ((new ShowController())->showRows(1));
  require_once __DIR__ . "\src\View\show.php";
} elseif (isset($_GET['id'])) {
  $rows = ((new ShowController())->showRow($_GET['id']));
  require_once __DIR__ . "\src\View\get.php";
} elseif (isset($_GET['page'])) {
  $rows = ((new ShowController())->showRows($_GET['page']));
  require_once __DIR__ . "\src\View\show.php";
} elseif (isset($_GET['sort'])) {
  $rows = ((new PDOLocal('php_advent_board'))->sort($_GET['sort'], 1));
  require_once __DIR__ . "\src\View\show.php";
}

$sort = new PDOLocal('php_advent_board');
if (isset($_GET['sort'])) {
  $sort->value($_GET['sort']);
  if ($_GET['sort'] === $sort->min) {
    $rows = ((new PDOLocal('php_advent_board'))->sort($sort->sort, 1));
    require_once __DIR__ . "\src\View\show.php";
  } else {
    $rows = ((new PDOLocal('php_advent_board'))->sort($sort->sort, 1));
    require_once __DIR__ . "\src\View\show.php";
  }
} elseif (isset($_GET['page'])) {
  $rows = ((new PDOLocal('php_advent_board'))->sort($sort->sort, $_GET['page']));
  require_once __DIR__ . "\src\View\show.php";
} else {
  $rows = ((new PDOLocal('php_advent_board'))->sort($sort->sort, $_GET['page']));
  require_once __DIR__ . "\src\View\show.php";
}


?>

<html>

<head>

</head>

<body>

  <form action="index.php" method='get'>
    <? $count = pagination(); ?>
    <? for ($i = 1; $i <= $count; $i++) { ?>
      <button type="submit" name="select" value='<? print $i ?>'><? print $i; ?></button>
    <? }; ?>
  </form>
  
  <form action="index.php" id="get">
    <label for="id">id</label>
    <input type="text" name="id" required>
  </form>
  <button type="submit" form="get">get</button>

  <form action="src\View\create.php">
    <input type="submit" value="create" />
  </form>

  <? if (isset($_GET['sort'])) { ?>
    <form action="index.php" method='get'>
      <input type="text" name="sort" value="min">
      <? $count = PaginationController::countSeparator(20); ?>
      <? for ($i = 1; $i <= $count; $i++) { ?>
        <button type="submit" name="page" value='<? print $i ?>'><? print $i; ?></button>
      <? }; ?>
    </form>
  <? }; ?>

  <form action="index.php">
    <input type="submit" value="show" />
  </form>
</body>

</html>