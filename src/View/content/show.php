<?php ob_start() ?>
<?php use App\Service\WidgetRender; ?>

<h1>Show</h1>
<table>
  <tr>
    <th>Id</th>
    <th>Item</th>
    <th>Description</th>
    <th>Price
      <a href="<?php $linkRender->getBasePath('/show/price/min/?page=1&filter=price'); ?>">▲</a>
      <a href="<?php $linkRender->getBasePath('/show/price/max/?page=1&filter=price'); ?>">▼</a>
      <a href="<?php $linkRender->getBasePath('/show?page=1'); ?>">✘</a>
    </th>

    <th>Image</th>
    <th>Date
      <a href="<?php $linkRender->getBasePath('/show/date/min/?page=1&filter=created_date'); ?>">▲</a>
      <a href="<?php $linkRender->getBasePath('/show/date/max/?page=1&filter=created_date'); ?>">▼</a>
      <a href="<?php $linkRender->getBasePath('/show?page=1'); ?>">✘</a>
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
        <img src=" <?php $linkRender->getBasePath('/public/img/user/', $row['image']); ?>"></a>
      </td>
      <td>
        <?= $row['created_date']; ?>
      </td>
    </tr>
  <?php }
  ; ?>
</table>

<?php WidgetRender::renderWidget('navigation'); ?>

<?php $content = ob_get_clean();
ob_end_clean(); ?>