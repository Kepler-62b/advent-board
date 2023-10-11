<?php use Framework\Services\Helpers\LinkManager; ?>

<table class="table table-hover table-bordered table-sm align-middle caption-top">
    <caption>Adverts</caption>
    <thead class="table-secondary">
    <tr>
        <?php foreach ($columnNames as $tableHeaders): ?>
            <th>
                <?= $tableHeaders ?>
            </th>
        <?php endforeach ?>
    </tr>
    </thead>

    <tbody class="table-group-divider">
    <?php foreach ($adverts as $advert): ?>
        <tr>
            <td>
                <?= $advert->getId() ?>
            </td>
            <td>
                <a class="table-link" href="<?= LinkManager::link('/images/get_relation', ['foreignKey' => $advert->getId()]) ?>"><?= $advert->getItem() ?></a>
            </td>
            <td>
                <?= $advert->getDescription() ?>
            </td>
            <td>
                <?= $advert->getPrice() ?>
            </td>
            <td>
                <img src="<?= LinkManager::linkImage('/public/img/user/', $advert->getImage()) ?>"
                     alt="<?= $advert->getImage() ?>">
            </td>
            <td>
                <?= $advert->getCreatedDate()->format('Y-m-d') ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>