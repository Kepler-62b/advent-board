<h3>Form</h3>
<hr>

<form action="<?= $linkRender->getRootPath("/get"); ?>" id="get" method="get">
  <input type="text" name="id" placeholder="item id" required>
</form>
<button type="submit" form="get">get</button>