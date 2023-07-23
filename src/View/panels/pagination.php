<?php ob_start() ?>

<!-- пагинация -->
<h3>Pagination</h3>
<hr>

  <? $count = $repository->getCountRows(); ?>
  <? for ($i = 1; $i <= $count; $i++) { ?>
    <a href="show?&page=<?= $i; ?>" class="btn"><?= $i; ?></a>
  <? }
  ; ?>
<!-- пагинация -->
<?php $pagination = ob_get_clean();
ob_end_clean(); ?>