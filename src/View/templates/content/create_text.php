<?php use App\Service\Helpers\LinkManager ?>

<body>
  <h1>Create</h1>

  <form action="<?= LinkManager::link('/create_action') ?>" method="post">
    <label for="item">item</label>
    <input type="text" name="item" required>

    <label for="description">description</label>
    <input type="text" name="description" required>
    
    <label for="price">price</label>
    <input type="text" name="price" required>

    <button>create</button>
  </form>

  <?= $navigation ?>

</body>