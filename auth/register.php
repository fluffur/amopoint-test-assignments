<?php

session_start();

if (!empty($_SESSION['user'])) {
    header('Location: /');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"], $_POST["email"], $_POST["password"])) {

    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];

    /** @var PDO $pdo */
    $pdo = require_once dirname(__DIR__) . '/db.php';

    $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `email` = ?');
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {

        echo '<p><a href="/">Домой</a></p>';
        die('Пользователь с таким email уже существует');
    }

    $pdo->prepare('INSERT INTO `users` (`name`, `email`, `password`) VALUES (:name, :email, :password)')
        ->execute([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    $_SESSION['user'] = ['id' => $pdo->lastInsertId(), 'name' => $name, 'email' => $email];
    header('Location: /');
    exit;
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация</title>
</head>
<body>
<p><a href="/">Домой</a></p>
<form method="post">
    <label for="name">Имя: </label>
    <input type="text" id="name" name="name">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email">

    <label for="password">Пароль</label>
    <input type="password" id="password" name="password">

    <input type="submit" value="Зарегистрироваться">
</form>
</body>
</html>