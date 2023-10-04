<?php use App\Service\Helpers\LinkManager; ?>

<form action="<?= LinkManager::link('/get') ?>" id="get" method="get">
    <div class="mb-3">
        <label for="inputId" class="form-label">
            <input type="text" name="id" id="inputId" placeholder="item id" class="form-control" required>
        </label>
    <button type="submit" form="get" class="btn btn-outline-primary">get</button>
    </div>
</form>
