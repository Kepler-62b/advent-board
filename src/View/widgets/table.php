<table>
  <tr>
    <?php foreach ($this->columns as $column) { ?>
      <th>
        <?= $column; ?>
      </th>
    <?php }; ?>
  </tr>

  <?php for ($i = 0; $i < count($this->rows); $i++) { ?>
    <tr>
      <?php foreach ($this->rows[$i] as $key => $row) {
        if (in_array($key, $this->columns)) { ?>
          <td>
            <?php if($key === 'image') { ?>
              <img src="/02-PROJECTS/php-projects/advent-board/public/img/user/<?= $row; ?>">
              <?php } else { ?>
                <?= $row; ?>
              <?php }; ?>
          </td>
        <?php }
      } ?>
    </tr>
  <?php }; ?>

</table>