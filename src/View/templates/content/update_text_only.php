<?php use App\Service\Helpers\LinkManager ?>

<body>
  <h1>Update</h1>

  <form action="<?= LinkManager::link('/update_action') ?>" method="post" enctype="multipart/form-data">
    <label for="id">id</label>
    <input type="text" name="id" required>

    <label for="item">item</label>
    <input type="text" name="item" value="update" required>

    <label for="description">description</label>
    <input type="text" name="description" value="update" required>

    <label for="price">price</label>
    <input type="text" name="price" value="321" required>

    <label for="image">image</label>
    <input type="text" name="image" value="update" required>

    <button>update</button>
  </form>

  <?= $navigation ?>

</body>