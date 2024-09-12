<?php

session_start();

if (!empty($_SESSION['user'])) {
    header('Location: /');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    /** @var PDO $pdo */
    $pdo = require_once dirname(__DIR__) . '/db.php';

    $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `email` = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($user) || !password_verify($password, $user['password'])) {
        die('Почта или пароль неверны');
    }

    $_SESSION['user'] = $user;

    header('Location: /');
    exit;
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход</title>
</head>
<body>
<p><a href="/">Домой</a></p>

<form method="post">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email">

    <label for="password">Пароль</label>
    <input type="password" id="password" name="password">

    <input type="submit" value="Войти">

</form>
</body>
</html>

