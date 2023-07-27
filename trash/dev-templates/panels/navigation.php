<?php ob_start() ?>

<hr>

<form action="<?php $linkRender->getBasePath("/get"); ?>" id="get">
  <label for="id">id</label>
  <input type="text" name="id" required>
</form>
<button type="submit" form="get">get</button>

<?php $navigation = ob_get_clean();
ob_end_clean(); ?>