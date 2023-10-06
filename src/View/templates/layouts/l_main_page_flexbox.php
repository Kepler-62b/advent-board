<!DOCTYPE html>
<html>

<head>
    <title>Advert-board</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
    <link rel="stylesheet" href="./public/css/flex.css" type="text/css"/>

</head>

<body>

<header>ADVERTS-BOARD</header>

<main class="flex-box">
    <nav class="nav">
        <?= $navigation_bootstrap_flex ?>
        <?= $form_get_flex ?>
    </nav>
    <div class="main"><?= $content ?></div>
</main>


</body>

</html>