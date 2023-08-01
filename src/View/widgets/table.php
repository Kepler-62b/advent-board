<table>
  <tr>
    <?php foreach ($columns as $keyColumn => $column) { ?>
      <th>
        <?php echo $column; } ?>
    </th>
  </tr>
  <?php for ($i = 0; $i < count($rows); $i++) { ?>
    <tr>
      <?php foreach ($rows[$i] as $key => $row) { ?>
        <?php if (array_key_exists($key, $columns)) { ?>
          <td>
            <?php if ($key === 'image') { ?>
              <img src="<?php echo $linkRender->getRootPath('/public/img/user/', $row); ?>">
            <?php } else { ?>
              <?php echo $row; ?>
            <?php }
            ; ?>
          </td>
        <?php }
      } ?>
    </tr>
  <?php }
  ; ?>

</table>