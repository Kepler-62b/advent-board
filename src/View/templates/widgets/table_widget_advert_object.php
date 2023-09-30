<?php use App\Service\Helpers\LinkManager ?>

<table>

  <tr>
    <?php foreach ($columnNames as $tableHeaders): ?>
      <th>
        <?= $tableHeaders ?>
      </th>
    <?php endforeach ?>
  </tr>

    <tr>
      <td>
        <?= $advert->getId() ?>
      </td>
      <td>
        <a href="<?= LinkManager::link('/not_found') ?>"><?= $advert->getItem() ?></a>
      </td>
      <td>
        <?= $advert->getDescription() ?>
      </td>
      <td>
        <?= $advert->getPrice() ?>
      </td>
      <td>
        <img src="<?= LinkManager::linkImage('/public/img/user/', $advert->getImage()) ?>" alt="<?= $advert->getImage() ?>">
      </td>
      <td>
        <?= $advert->getCreatedDate()->format('Y-m-d') ?>
      </td>
    </tr>


</table>