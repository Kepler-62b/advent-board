<h3>Pagination</h3>
<hr>
<?
for ($i = 1; $i <= $count; $i++) { ?>
  <a href="<?= $linkRender->getPath(); ?>?page=<?= $i; ?><?= $linkRender->getFilter('price'); ?>" class="btn"><?= $i; ?></a>
<? }
; ?>