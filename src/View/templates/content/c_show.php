<?php
/**
 * @var LinkeRender $linkRender
*/
?>
<h1>Show</h1>
<table>
  <tr>
    <th>Id</th>
    <th>Item</th>
    <th>Description</th>
    <th>Price
      <a href="<?php echo $linkRender->getRootPath('/show/price/min/', '?page=1&filter=price'); ?>">▲</a>
      <a href="<?php echo $linkRender->getRootPath('/show/price/max/', '?page=1&filter=price'); ?>">▼</a>
      <a href="<?php echo $linkRender->getRootPath('/show', '?page=1'); ?>">✘</a>
    </th>

    <th>Image</th>
    <th>Date
      <a href="<?php echo $linkRender->getRootPath('/show/date/min/', '?page=1&filter=created_date'); ?>">▲</a>
      <a href="<?php echo $linkRender->getRootPath('/show/date/max/', '?page=1&filter=created_date'); ?>">▼</a>
      <a href="<?php echo $linkRender->getRootPath('/show', '?page=1'); ?>">✘</a>
    </th>
  </tr>
  <?php foreach ($rows as $row) { ?>
    <tr>
      <td>
        <?= $row['id']; ?>
      </td>
      <td>
        <?= $row['item']; ?>
      </td>
      <td>
        <?= $row['description']; ?>
      </td>
      <td>
        <?= $row['price']; ?>
      </td>
      <td>
        <img src=" <?php echo $linkRender->getRootPath('/public/img/user/', $row['image']); ?>">
      </td>
      <td>
        <?= $row['created_date']; ?>
      </td>
    </tr>
  <?php }
  ; ?>
</table>


<?= $widgets['pagination']; ?>
<?= $widgets['table']; ?>
<?= $widgets['navigation']; ?>
<?= $widgets['getForm']; ?>