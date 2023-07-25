<?php ob_start() ?>

<h3>Navigation</h3>
<hr>

<form action="<?php $linkManager->getBasePath("/get"); ?>" id="get">
  <label for="id">id</label>
  <input type="text" name="id" required>
</form>
<button type="submit" form="get">get</button>

<ul>
 <li><a href="<?php $linkManager->getBasePath("/create"); ?>">Create</a></li>
 <li><a href="<?php $linkManager->getBasePath("/update"); ?>">Update</a></li>
</ul>

<?php $navigation = ob_get_clean();
ob_end_clean(); ?>