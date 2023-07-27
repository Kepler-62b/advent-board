<?php ob_start() ?>
<?php use App\Service\LinkManager; ?>

<h3>Navigation</h3>
<hr>

<form action="<?php $linkRender->getBasePath("/get"); ?>" id="get">
  <label for="id">id</label>
  <input type="text" name="id" required>
</form>
<button type="submit" form="get">get</button>

<?php $navigationWidget = ob_get_clean(); ?>