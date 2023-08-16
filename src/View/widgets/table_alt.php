<?php use App\Service\Helpers\LinkManager ?>

<table>

  <tr>
    <?php foreach ($columnNames as $tableHeaders): ?>
      <th>
        <?= $tableHeaders ?>
      </th>
    <?php endforeach ?>
  </tr>

  <?php for ($i = 0; $i < count($rows); $i++): ?>
    <tr>
      <td>
        <?= $rows[$i]['id'] ?>
      </td>
      <td>
        <a href="<?= LinkManager::link('/update') ?>"><?= $rows[$i]['item'] ?></a>
      </td>
      <td>
        <?= $rows[$i]['description'] ?>
      </td>
      <td>
        <?= $rows[$i]['price'] ?>
      </td>
      <td>
        <img src="<?= LinkManager::linkImage('/public/img/user/', $rows[$i]['image']) ?>" alt="<?= $rows[$i]['image'] ?>">
      </td>
      <td>
        <?= $rows[$i]['created_date'] ?>
      </td>
    </tr>
  <?php endfor ?>




</table>