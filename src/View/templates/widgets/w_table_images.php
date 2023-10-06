<?php use App\Service\Helpers\LinkManager ?>
<h1>Images</h1>
<h2>Advert <?= $images[0]->getItemId() ?></h2>

<table>
    <tr>
        <?php foreach ($columnNames as $tableHeaders): ?>
            <th>
                <?= $tableHeaders ?>
            </th>
        <?php endforeach ?>
    </tr>
    <?php foreach ($images as $image): ?>
        <tr>
            <td>
                <?= $image->getId() ?>
            </td>
            <td>
                <?= $image->getName() ?>
            </td>
            <td>
                <img src="<?= LinkManager::linkImage('/public/img/user/', $image->getName()) ?>"
                     alt="<?= $image->getName() ?>" >
            </td>
        </tr>
    <?php endforeach ?>
</table>