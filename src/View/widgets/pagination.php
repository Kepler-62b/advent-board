<h3>Pagination</h3>
<hr>
<?
for ($i = 1; $i <= $count; $i++) { ?>
  <a href="<?php echo $linkRender->getPath(); ?>?page=<?= $i; ?><?php echo $linkRender->sort('price'); ?>" class="btn"><?= $i; ?></a>
<? }
; ?>