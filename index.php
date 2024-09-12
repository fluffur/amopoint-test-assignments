<?php session_start(); ?>
<!DOCTYPE html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<?php if (empty($_SESSION['user'])): ?>
    <p>Чтобы узнать статистику посещений, нужно авторизоваться на сайте</p>
    <div>
        <a href="auth/register.php">Регистрация</a>
    </div>
    <div>
        <a href="auth/login.php">Вход</a>

    </div>
<?php else: ?>
    <div>Привет, <i><?= $_SESSION['user']['name'] ?></i></div>
    <div><a href="/stats.php">Узнать статистику</a></div>
    <div><a href="/auth/logout.php">Выйти</a></div>
<?php endif; ?>
<script src="script.js"></script>
</body>
</html>