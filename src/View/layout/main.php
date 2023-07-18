<?php ob_start() ?>

<!DOCTYPE html>
<html>

<head>
  <title>Show</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">

  <style>
    .btn {
      display: inline-block;
      /* Строчно-блочный элемент */
      background: #8C959D;
      /* Серый цвет фона */
      color: #fff;
      /* Белый цвет текста */
      padding: 1rem 1.5rem;
      /* Поля вокруг текста */
      text-decoration: none;
      /* Убираем подчёркивание */
      border-radius: 3px;
      /* Скругляем уголки */
    }
  </style>

</head>

<body>

  <?php print $content; ?>


</body>

</html>

<?php $layout = ob_get_clean();
ob_end_clean(); ?>