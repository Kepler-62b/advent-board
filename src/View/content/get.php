<?php use App\Service\WidgetRender; ?>
<?php ob_start() ?>

<table>
  <tr>
    <th>Id</th>
    <th>Item</th>
    <th>Description</th>
    <th>Price</th>
    <th>Image</th>
    <th>Created_date</th>
  </tr>
</table>
<table>
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
        <?= $row['image']; ?>
      <td>
        <?= $row['created_date']; ?>
      </td>
    </tr>
  <?php }
  ; ?>
</table>

<?php WidgetRender::renderWidget('form_get_item'); ?>
<?php WidgetRender::renderWidget('navigation'); ?>

<?php $content = ob_get_clean();
ob_end_clean(); ?>