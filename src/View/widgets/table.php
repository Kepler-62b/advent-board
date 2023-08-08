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
      <?php foreach ($rows[$i] as $rowHeaders => $row): ?>
        <?php if (array_key_exists($rowHeaders, $columnNames)): ?>
          <td>
            <?php if (in_array($rowHeaders, $this->linkImages)): ?>
              <img src="<?= $linkRender->getRootPath('/public/img/user/', $row) ?>">
            <?php else: ?>
              <?= $row; ?>
            <?php endif ?>
          </td>
        <?php endif ?>
      <?php endforeach ?>
    </tr>
  <?php endfor ?>

</table>