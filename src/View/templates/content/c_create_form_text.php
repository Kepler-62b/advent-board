<?php use Framework\Services\Helpers\LinkManager; ?>

<h1>Create</h1>

<form action="<?= LinkManager::link('/create_action') ?>" method="post">
    <div class="mb-3">
        <label class="form-label" for="item">item</label>
        <input class="form-control" type="text" name="item" value="new item" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="description">description</label>
        <input class="form-control" type="text" name="description" value="create description" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="price">price</label>
        <input class="form-control" type="text" name="price" value="<?= rand(1, 1000); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="image">image</label>
        <input class="form-control" type="text" name="image" value="create.jpeg" required>
    </div>
    <button class="btn btn-primary">create</button>
</form>