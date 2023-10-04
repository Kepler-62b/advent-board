<?php use App\Service\Helpers\LinkManager; ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand">Navigation</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href='<?= LinkManager::link('/') ?>'>Home page</a>
                <a class="nav-link" href='<?= LinkManager::link('/show', ['page' => 1]) ?>'>Show</a>
                <a class="nav-link" href='<?= LinkManager::link('/create') ?>'>Create</a>
                <a class="nav-link" href='<?= LinkManager::link('/update') ?>'>Update</a>
            </div>
        </div>
    </div>
</nav>
