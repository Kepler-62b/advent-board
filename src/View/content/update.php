<?php use App\Service\WidgetRender; ?>

<body>
  <h1>Update</h1>

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

  <?php WidgetRender::renderWidget('navigation'); ?>

</body>