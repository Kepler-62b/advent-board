<?php use App\Service\Helpers\LinkManager; ?>
<h3>Navigation</h3>
<hr>

<ul>
    <li><a href='<?= LinkManager::link('/') ?>'>Home page</a></li>
    <ul>
        <li><a href='<?= LinkManager::link('/show', ['page' => 1]) ?>'>Show</a></li>
        <li><a href='<?= LinkManager::link('/create') ?>'>Create</a></li>
        <li><a href='<?= LinkManager::link('/update') ?>'>Update</a></li>
    </ul>
</ul>
