<?php use App\Service\LinkManager; ?>
<?php use App\Service\ControllerContainer; ?>
<?php use App\Repository\AdventRepository; ?>


<h3>Pagination</h3>
<hr>
<?
$repository = (new ControllerContainer())->get(AdventRepository::class);
$count = $repository->getCountRows();
for ($i = 1; $i <= $count; $i++) { ?>
  <a href="<?php LinkManager::getPath(); ?>?page=<?= $i; ?><?php LinkManager::getQuery(); ?>" class="btn"><?= $i; ?></a>
<? }
; ?>
