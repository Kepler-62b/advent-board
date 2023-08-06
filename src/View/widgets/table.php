<table>
  <tr>
    <?php foreach ($columns as $tableHeaders) { ?>
      <th>
        <?= $tableHeaders ?>
      </th>
    <?php } ?>
  </tr>
  <?php for ($i = 0; $i < count($rows); $i++) { ?>
    <tr>
      <?php foreach ($rows[$i] as $rowHeaders => $row) { ?>
        <?php if (array_key_exists($rowHeaders, $columns)) { ?>
          <td>
            <?php if ($rowHeaders === 'image') { ?>
              <img src="<?php echo $linkRender->getRootPath('/public/img/user/', $row); ?>">
            <?php } else { ?>
              <?= $row; ?>
            <?php } ?>
          </td>
        <?php }
      } ?>
    </tr>
  <?php } ?>

</table>