<?php use App\Service\Helpers\LinkManager; ?>

<span>
  <?= $columnName ?>
</span>

<a class="text-decoration-none" href="<?= LinkManager::link('/show/sort/min/', ['page' => 1, 'filter' => $filter]) ?>">▲</a>
<a class="text-decoration-none" href="<?= LinkManager::link('/show/sort/max/', ['page' => 1, 'filter' => $filter]) ?>">▼</a>
<a class="text-decoration-none" href="<?= LinkManager::link('/show', ['page' => 1]) ?>">✘</a>