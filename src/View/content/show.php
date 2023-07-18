<?php ob_start() ?>



<body>
  <h1>Show</h1>
  <table>
    <? if (isset($_GET['select'])) { ?>
      <caption>
        <? print "page " . $_GET['select']; ?>
      </caption>
    <? }; ?>
    <tr>
      <th>Id</th>
      <th>Item</th>
      <th>Description</th>
      <!-- сортировка по цене -->
      <? if (empty($_GET)) { ?>
        <th>
          <a href="index.php?sort=max&filter=price">Price</a>
        </th>
      <? } elseif (isset($_GET['page']) && $_GET['sort'] === "def") { ?>
        <th>
          <a href="index.php?sort=max&filter=price">Price</a>
        </th>
      <? } elseif ($_GET['sort'] === "max" && $_GET['filter'] === "price") { ?>
        <th>Price
          <a href="index.php?sort=min&filter=price">▼</a>
          <a href="index.php?page=1&sort=def">✘</a>
        </th>
      <? } elseif ($_GET['sort'] === "min" && $_GET['filter'] === "price") { ?>
        <th>Price
          <a href="index.php?sort=max&filter=price">▲</a>
          <a href="index.php?page=1&sort=def">✘</a>
        </th>
      <? } else { ?>
        <th>
          <a href="index.php?sort=max&filter=price">Price</a>

        </th>
      <? } ?>
      <!-- сортировка по цене -->

      <th>Image</th>
      <!-- сортировка по дате -->
      <? if (empty($_GET)) { ?>
        <th>
          <a href="index.php?sort=max&filter=created_date">Date</a>
        </th>
      <? } elseif (isset($_GET['page']) && isset($_GET['sort']) === "def") { ?>
        <th>
          <a href="index.php?sort=max&filter=created_date">Date</a>
        </th>
      <? } elseif ($_GET['sort'] === "max" && $_GET['filter'] === "created_date") { ?>
        <th>Date
          <a href="index.php?sort=min&filter=created_date">▼</a>
          <a href="index.php?page=1&sort=def">✘</a>
        </th>
      <? } elseif ($_GET['sort'] === "min" && $_GET['filter'] === "created_date") { ?>
        <th>Date
          <a href="index.php?sort=max&filter=created_date">▲</a>
          <a href="index.php?page=1&sort=def">✘</a>
        </th>
      <? } else { ?>
        <th>
          <a href="index.php?sort=max&filter=created_date">Date</a>
        </th>
      <? } ?>
      <!-- сортировка по дате -->

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
        <!-- менять директорию с системными картинками -->
        <td><img src=" <?= "public/img/user/" . $row['image']; ?>"></a></td>
        <td>
          <?= $row['created_date']; ?>
        </td>
      </tr>
    <?php }; ?>
  </table>
</body>

<?php $content = ob_get_clean();
ob_end_clean(); ?>