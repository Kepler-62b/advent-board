<!DOCTYPE html>
<html>

<head>
  <title>Show</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">

</head>

<body>
  <h1>Show</h1>
  <table>
    <? if (isset($_GET['select'])) { ?>
      <caption><? print "page " . $_GET['select']; ?></caption>
    <? }; ?>
    <tr>
      <th>id</th>
      <th>item</th>
      <th>description</th>
      <th>price</th>
      <th>image</th>
    </tr>
    <?php foreach ($rows as $row) { ?>
      <tr>
        <td><?= $row['id']; ?> </td>
        <td><?= $row['item']; ?></td>
        <td><?= $row['description']; ?></td>
        <td><?= $row['price']; ?></td>
        <td><img src=" <?= "public\\img\\user\\" . $row['image']; ?>"></a></td>
      </tr>
    <?php }; ?>
  </table>
</body>

</html>