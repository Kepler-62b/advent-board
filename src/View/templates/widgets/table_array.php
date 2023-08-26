<?php use App\Service\Helpers\LinkManager ?>

<table>

  <tr>
    <?php foreach ($columnNames as $tableHeaders): ?>
      <th>
        <?= $tableHeaders ?>
      </th>
    <?php endforeach ?>
  </tr>

  <?php foreach ($rows as $row): ?>
    <tr>
      <td>
        <?= $row->getId() ?>
      </td>
      <td>
        <a href="<?= LinkManager::link('/not_found') ?>"><?= $row->getItem() ?></a>
      </td>
      <td>
        <?= $row->getDescription() ?>
      </td>
      <td>
        <?= $row->getPrice() ?>
      </td>
      <td>
        <img src="<?= LinkManager::linkImage('/public/img/user/', $row->getImage()) ?>" alt="<?= $row->getImage() ?>">
      </td>
      <td>
        <?= $row->getCreatedDate() ?>
      </td>
    </tr>
  <?php endforeach ?>


</table>