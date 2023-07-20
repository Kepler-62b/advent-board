<?php ob_start() ?>

<!-- пагинация -->
<h3>Pagination</h3>
<hr>

<? if (empty($_GET) && !isset($_GET['id'])) { ?>
  <? $count = App\Controllers\PaginationController::countSeparator(5); ?>
  <? for ($i = 1; $i <= $count; $i++) { ?>
    <a href="index.php?&page=<?= $i; ?>&sort=def" class="btn"><?= $i; ?></a>
  <? }
  ; ?>
<? } elseif (isset($_GET['filter']) && isset($_GET['sort']) && !isset($_GET['id'])) { ?>
  <!-- возможно убрать isset($_GET['sort'] из условия -->
  <? $count = App\Controllers\PaginationController::countSeparator(5); ?>
  <? for ($i = 1; $i <= $count; $i++) { ?>
    <a href="index.php?&page=<?= $i; ?>&sort=<?= $_GET['sort']; ?>&filter=<?= $_GET['filter']; ?>" class="btn"><?= $i; ?></a>
  <? }
  ; ?>
  <!-- разобраться с условием isset($_GET['id']) -->
<? } elseif (isset($_GET['id'])) {
  ; ?>

<? } elseif (isset($_GET['page']) && isset($_GET['sort']) && !isset($_GET['id'])) { ?>
  <? $count = App\Controllers\PaginationController::countSeparator(5); ?>
  <? for ($i = 1; $i <= $count; $i++) { ?>
    <a href="index.php?&page=<?= $i; ?>&sort=<?= $_GET['sort']; ?>" class="btn"><?= $i; ?></a>
  <? }
  ; ?>
<? }
; ?>
<!-- пагинация -->
<?php $pagination = ob_get_clean();
ob_end_clean(); ?>