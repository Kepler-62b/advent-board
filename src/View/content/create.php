<?php ob_start() ?>

<body>
  <h1>Create</h1>

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

  <ul>
    <li><a href="update">Update</a></li>
    <li><a href="show?page=1">Show</a></li>
  </ul>

</body>

<?php $content = ob_get_clean();
ob_end_clean(); ?>