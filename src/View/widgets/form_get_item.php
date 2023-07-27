<?php ob_start() ?>
<?php use App\Service\LinkManager; ?>

<h3>Form</h3>
<hr>

<form action="<?php LinkManager::getBasePath("/get"); ?>" id="get">
  <input type="text" name="id" placeholder="item id" required>
</form>
<button type="submit" form="get">get</button>

<?php $widget = ob_get_clean(); ?>