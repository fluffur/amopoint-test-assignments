<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка файла</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Загрузка файла</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="textFile" id="textFile">
        <input type="submit" value="Загрузить файл" name="submit">
    </form>

    <?php if (isset($_GET['status'])): ?>
        <div class="card">
            <div class="status <?= $_GET['status'] ?>"></div>
            <?php if ($_GET['status'] == 'success'): ?>
                <div><?= $_GET['file_name'] ??= 'Неизвестный файл' ?></div>
                <div><a href="<?= $_GET['file_path'] ??= '' ?>" class="href">Путь к файлу</a></div>
            <?php else: ?>
                <div><?= $_GET['error'] ?></div>
            <?php endif; ?>

        </div>
        <ul class="lines-list">
            <?php
            require_once 'helpers.php';

            $lines = file_get_contents($_GET['file_path']);
            $lines = explode("\n", $lines);
            $lines = array_map('countDigits', $lines);
            ?>

            <?php foreach ($lines as $lineNumber => $digits): ?>
                <li class="line"><?= $lineNumber + 1 ?> = <?= $digits ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>

</body>
</html>