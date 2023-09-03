<?php use App\Service\Helpers\LinkManager ?>

<body>
  <h1>Create</h1>

  <form action="<?= LinkManager::link('/create_action') ?>" method="post" enctype="multipart/form-data">

    <label for="image">image</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <input type="file" name="userfile">

    <button>create</button>
  </form>

  <?= $navigation ?>

</body>