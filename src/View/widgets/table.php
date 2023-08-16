<?php use App\Service\Helpers\LinkManager ?>

<table>
  <tr>
    <?php foreach ($columnNames as $tableHeaders): ?>
      <th>
        <?= $tableHeaders ?>
      </th>
    <?php endforeach ?>
    <?= var_dump($columnNames) ?>
    <?= var_dump($rows[0]) ?>
  </tr>
  <?php for ($i = 0; $i < count($rows); $i++): ?>
    <tr>
      <?php foreach ($rows[$i] as $rowHeaders => $row): ?>
        <?php if (array_key_exists($rowHeaders, $columnNames)): ?>
          <td>
            <?php if (in_array($rowHeaders, $linkImages)): ?>
              <img src="<?= LinkManager::linkImage('/public/img/user/', $row) ?>" alt="<?= $row ?>">
            <?php else: ?>
              <?= $row; ?>
            <?php endif ?>
          </td>
        <?php endif ?>
      <?php endforeach ?>
    </tr>
  <?php endfor ?>

</table>