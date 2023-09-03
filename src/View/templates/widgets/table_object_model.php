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
        <?= $rows->getId() ?>
      </td>
      <td>
        <a href="<?= LinkManager::link('/not_found') ?>"><?= $rows->getItem() ?></a>
      </td>
      <td>
        <?= $rows->getDescription() ?>
      </td>
      <td>
        <?= $rows->getPrice() ?>
      </td>
      <td>
        <img src="<?= LinkManager::linkImage('/public/img/user/', $rows->getImage()) ?>" alt="<?= $rows->getImage() ?>">
      </td>
      <td>
        <?= $rows->getCreatedDate()->format('Y-m-d') ?>
      </td>
    </tr>


</table>