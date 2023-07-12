<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">

  <title>show</title>
</head>

<body>
  <!-- форма для сортировки кнопками -->
  <h3>Sort</h3>
  <form action="index.php" method="get">
    <hr>
    <div>filtr
      <input type="radio" name="filtr" value="created_date">date
      <input type="radio" name="filtr" value="price">price
    </div>
    <hr>
    <div>sort
      <input type="radio" name="sort" value="min">min
      <input type="radio" name="sort" value="max">max
      <input type="radio" name="sort" value="default">default
    </div>
    <hr>
    <button type="submit">Sorting</button>
    <div>
      <button type="submit" name="page" value="1">1</button>

    </div>

  </form>
  <!-- форма для сортировки кнопками -->

  <!-- ссылки для сортировки -->
  <a href="../../index.php?sort=min">Price min</a>
  <a href="../../index.php?sort=max">Price max</a>

  <!-- ссылки для сортировки -->


  <!-- пагинация -->
  <h3>Navigation</h3>

  <? if (!isset($_GET['id'])) { ?>
    <form action="index.php" method='get'>
      <? $count = PaginationController::countSeparator(2); ?>

      <? for ($i = 1; $i <= $count; $i++) { ?>
        <button type="submit" name="page" value='<? print $i ?>'><? print $i; ?></button>
      <? }; ?>
    </form>
    <form action="index.php">
      <button type="submit" name="sort" value="min">price min</button>
      <button type="submit" name="sort" value="max">price max</button>
      <button type="submit" name="sort" value="def">default</button>
    </form>
  <? }; ?>
  <!-- пагинация -->

  <form action="index.php" id="get">
    <label for="id">id</label>
    <input type="text" name="id" required>
  </form>
  <button type="submit" form="get">get</button>

  <form action="src\View\create.php">
    <input type="submit" value="create" />
  </form>



  <? if (isset($_GET['id'])) { ?>
    <form action="index.php">
      <input type="submit" value="show" />
    </form>
  <? }; ?>

</body>

</html>

