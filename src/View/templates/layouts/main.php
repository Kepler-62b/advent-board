<!DOCTYPE html>
<html>

<head>
    <title>Show</title>
    <!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">-->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
            crossorigin="anonymous"></script>


    <!-- стили для кнопок   -->
    <style>
        .pagination-btn {
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

<?= $navigation_bootstrap ?>
<?= $content ?>

</body>

</html>