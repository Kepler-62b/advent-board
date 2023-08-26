<?php use App\Service\Helpers\LinkManager ?>

<?php
/**
 * @var string $columnName
 * @var string $filter
 */
?>

<span>
  <?= $columnName ?>
</span>

<a href="<?= LinkManager::link('/show/sort/min/', ['page' => 1, 'filter' => $filter]) ?>">▲</a>
<a href="<?= LinkManager::link('/show/sort/max/', ['page' => 1, 'filter' => $filter]) ?>">▼</a>
<a href="<?= LinkManager::link('/show', ['page' => 1]) ?>">✘</a>