<?php ob_start() ?>
<?php use App\Service\LinkManager; ?>


<h3>Pagination</h3>
<hr>
<? $count = $repository->getCountRows(); ?>
<? for ($i = 1; $i <= $count; $i++) { ?>
  <a href="<?php LinkManager::getPath(); ?>?page=<?= $i; ?><?php LinkManager::getQuery(); ?>" class="btn"><?= $i; ?></a>
<? }
; ?>

<?php $paginationWidget = ob_get_clean(); ?>