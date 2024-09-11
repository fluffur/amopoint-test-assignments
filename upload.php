<?php

require_once 'helpers.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST" ||
    !isset($_FILES["textFile"])) {
    redirectWithData('index.php', [
        'status' => 'error',
        'error' => 'Запрос не отправляет файл',
    ]);
}

$uploadFileName = $_FILES['textFile']['name'];
if (!str_ends_with($uploadFileName, '.txt')) {
    redirectWithData('index.php', [
        'status' => 'error',
        'error' => 'Файл должен быть формата ".txt"',
        'file_name' => $uploadFileName,
    ]);
}

$uploadDirectory = 'files/';

$uploadFile = $uploadDirectory . basename($_FILES['textFile']['name'], '.txt') . '_' . date('YmdHis') . '.txt';

move_uploaded_file($_FILES['textFile']['tmp_name'], $uploadFile);


redirectWithData('index.php', [
    'status' => 'success',
    'file_name' => $uploadFileName,
    'file_path' => $uploadFile,
]);