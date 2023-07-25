<?php ob_start() ?>

<h3>Pagination</h3>
<hr>
  <? $count = $repository->getCountRows(); ?>
  <? for ($i = 1; $i <= $count; $i++) { ?>
    <a href="<?= $linkManager->getPath(); ?>?page=<?= $i; ?><?= $linkManager->getQuery(); ?>" class="btn"><?= $i; ?></a>
  <? }
  ; ?>

<?php $pagination = ob_get_clean();
ob_end_clean(); ?>