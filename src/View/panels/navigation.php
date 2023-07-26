<?php ob_start() ?>

<h3>Navigation</h3>
<hr>

<form action="<?php $linkRender->getBasePath("/get"); ?>" id="get">
  <label for="id">id</label>
  <input type="text" name="id" required>
</form>
<button type="submit" form="get">get</button>

<ul>
 <li><a href="<?php $linkRender->getBasePath("/create"); ?>">Create</a></li>
 <li><a href="<?php $linkRender->getBasePath("/update"); ?>">Update</a></li>
</ul>

<?php $navigation = ob_get_clean();
ob_end_clean(); ?>