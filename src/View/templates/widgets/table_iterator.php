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
        <?= $row->{'id'} ?>
      </td>
      <td>
        <a href="<?= LinkManager::link('/not_found') ?>"><?= $row->{'item'} ?></a>
      </td>
      <td>
        <?= $row->{'description'} ?>
      </td>
      <td>
        <?= $row->{'price'} ?>
      </td>
      <td>
        <img src="<?= LinkManager::linkImage('/public/img/user/', $row->{'image'}) ?>" alt="<?= $row->{'image'} ?>">
      </td>
      <td>
        <?= $row->{'created_date'} ?>
      </td>
    </tr>
  <?php endforeach ?>


</table>