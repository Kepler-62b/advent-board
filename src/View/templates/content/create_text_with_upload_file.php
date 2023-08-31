<?php use App\Service\Helpers\LinkManager ?>

<body>
  <h1>Create</h1>

  <form action="<?= LinkManager::link('/create_action') ?>" method="post" enctype="multipart/form-data">

    <label for="item">item</label>
    <input type="text" name="item" value="test upload item" required>

    <label for="description">description</label>
    <input type="text" name="description" value="test upload description" required>

    <label for="price">price</label>
    <input type="text" name="price" value="111" required>

    <label for="image">image</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <input type="file" name="userfile">

    <button>create</button>
  </form>

  <?= $navigation ?>

</body>