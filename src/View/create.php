<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">

  <title>Create</title>
</head>

<body>
  <h1>Create</h1>

  <div>
    <? if ($_SERVER['HTTP_REFERER'] === 'http://advent-board/src/View/create.php?') {
      print("exceeded the allowed number of characters");
    }
    ?>
  </div>

  <form action="index.php" method="post" enctype="multipart/form-data">
    <label for="item">item</label>
    <input type="text" name="item" required>
    <label for="description">description</label>
    <input type="text" name="description" required>
    <label for="price">price</label>
    <input type="text" name="price" required>
    <label for="image">image</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <input type="file" name="userfile">
    <button>create</button>
  </form>




  <a href="index.php">Show</a>
</body>

</html>