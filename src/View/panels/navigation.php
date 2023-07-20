<?php ob_start() ?>

<h3>Navigation</h3>
<hr>

<form action="index.php" id="get">
  <label for="id">id</label>
  <input type="text" name="id" required>
</form>
<button type="submit" form="get">get</button>

<form action="src\View\create.php">
  <input type="submit" value="create" />
</form>

<? if (isset($_GET['id']) || isset($_POST['id'])) { ?>
  <form action="index.php">
    <input type="submit" value="show" />
  </form>
<? }; ?>

<?php $navigation = ob_get_clean();
ob_end_clean(); ?>
