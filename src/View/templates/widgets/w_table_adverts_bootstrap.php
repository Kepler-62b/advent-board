<?php use Framework\Services\Helpers\LinkManager; ?>

<h3>Adverts</h3>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <?php foreach ($columnNames as $tableHeaders): ?>
                <th>
                    <?= $tableHeaders ?>
                </th>
            <?php endforeach ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($adverts as $advert): ?>
            <tr>
                <td>
                    <?= $advert->getId() ?>
                </td>

                <td>
                    <a
                            class="text-decoration-none"
                            href="<?= LinkManager::link('/images/get_relation', ['foreignKey' => $advert->getId()]) ?>">
                        <?= $advert->getItem() ?>
                    </a>

                </td>

                <td>
                    <?= $advert->getDescription() ?>
                </td>

                <td>
                    <?= $advert->getPrice() ?>
                </td>

                <td>
                    <img src="<?= LinkManager::linkImage('/public/img/user/', $advert->getImage()) ?>"
                         alt="<?= $advert->getImage() ?>" width="50" height="50">
                </td>

                <td>
                    <?= $advert->getCreatedDate()->format('Y-m-d') ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>