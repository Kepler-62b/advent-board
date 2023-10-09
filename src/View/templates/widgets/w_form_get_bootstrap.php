<?php use App\Service\Helpers\LinkManager; ?>

<div class="container-fluid">
    <form action="<?= LinkManager::link('/get') ?>" id="get" method="get">
        <div class="d-flex mb-3">
            <input name="id" type="text" class="form-control me-2" placeholder="Item Id" required>
        </div>
        <button class="btn btn-outline-success" form="get" type="submit">Get</button>
    </form>
</div>
