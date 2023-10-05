<?php use App\Service\Helpers\LinkManager; ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="navbar-nav-scroll">
            <a class="navbar-brand">Navigation</a>
            <a class="nav-link active" aria-current="page" href='<?= LinkManager::link('/') ?>'>Home page</a>
            <a class="nav-link" href='<?= LinkManager::link('/show', ['page' => 1]) ?>'>Show</a>
            <a class="nav-link" href='<?= LinkManager::link('/create') ?>'>Create</a>
            <a class="nav-link" href='<?= LinkManager::link('/update') ?>'>Update</a>
        </div>
    </div>
</nav>
