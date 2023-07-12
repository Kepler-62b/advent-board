<!DOCTYPE html>
<html>

<head>
  <title>Get</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">

</head>

<body>
  <h1>Get</h1>

  <div>
    <img src=" <?= "public\\img\\user\\" . $row['image']; ?>" alter="<?= $row['image']; ?>">
  </div>
  <div>
    <p> Item: <?= $row["item"]; ?> </p>
    <? if (isset($_GET["fields"])) { ?>
      <p> Description: <?= $row["description"]; ?> </p>
      <p> Price: <?= $row["price"]; ?> RUB</p>
    <? }; ?>
  </div>
  <!-- форма для получения полей -->
  <form action="../../index.php" method="get">
    <div>
      <label>all fields</label>
      <!-- <input type="checkbox" name="fields"> -->
      <input type="hidden" name="fields">
      <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
    </div>
    <div>
      <button type="submit">get</button>
    </div>
  </form>
  <!-- форма для получения полей -->

  <!-- форма для добавления картинки -->
  <form action="../../index.php" method="post" enctype="multipart/form-data">
    <div>
      <label>add image</label>
      <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
      <input type="file" name="userfile">
      <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
    </div>
    <div>
      <button type="submit">add</button>
    </div>
  </form>
  <!-- форма для добавления картинки -->






</body>

</html>