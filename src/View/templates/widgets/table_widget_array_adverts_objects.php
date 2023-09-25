<?php use App\Service\Helpers\LinkManager ?>
<h1>Adverts</h1>

<table>

  <tr>
    <?php foreach ($columnNames as $tableHeaders): ?>
      <th>
        <?= $tableHeaders ?>
      </th>
    <?php endforeach ?>
  </tr>

  <?php foreach ($adverts as $advert): ?>
    <tr>
      <td>
        <?= $advert->getId() ?>
      </td>
      <td>
        <a href="<?= LinkManager::link('/images/get_relation', ['foreignKey' => $advert->getId()]) ?>"><?= $advert->getItem() ?></a>
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
  <?php endforeach ?>


</table>