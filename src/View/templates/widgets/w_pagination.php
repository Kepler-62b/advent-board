<?php use Framework\Services\Helpers\LinkManager; ?>

<h3>Pagination</h3>
<hr>
<?php for ($i = 1; $i <= $count; $i++): ?>
  <a href="<?= LinkManager::link('/show', ['page' => $i], ['filter']) ?>" class="btn"><?= $i; ?></a>
<?php endfor ?>