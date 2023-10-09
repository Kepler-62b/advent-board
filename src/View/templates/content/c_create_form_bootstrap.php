<?php use App\Service\Helpers\LinkManager; ?>

<h2>Create</h2>
<div class="mb-2">
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
        <button class="btn btn-primary">Create</button>
    </form>
</div>
<div class="mb-2">
    <a class="btn btn-outline-primary" href='<?= LinkManager::returnReferenceLink() ?>'>Back</a>
</div>