<?php use App\Service\Helpers\LinkManager; ?>

<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Images album</h1>
            <a href="#" class="btn btn-primary my-2">Main call to action</a>
            <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p>
        </div>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($images as $image): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img class="rounded mx-auto d-block"
                             src="<?= LinkManager::linkImage('/public/img/user/', $image->getName()) ?>"
                             alt="<?= $image->getName() ?>" width="100" height="100">
                        <div class="card-body">
                            <p class="card-text"><?= $image->getName() ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Delete</button>
                                </div>
                                <small class="text-muted">created: <?= $image->getCreatedDate()->format('Y-m-d') ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
