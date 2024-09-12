<?php

$post = json_decode(file_get_contents('php://input'), true);
if (empty($post['ip']) || empty($post['city']) || empty($post['platform'])) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();

/** @var PDO $pdo */
$pdo = require_once __DIR__ . '/db.php';


$locationStmt = $pdo->prepare('SELECT * FROM `locations` WHERE `ip` = ?');
$locationStmt->execute([$post['ip']]);
$location = $locationStmt->fetch(PDO::FETCH_ASSOC);

if (!empty($location)) {
    exit;
}

$pdo->prepare('INSERT INTO `locations` (`ip`, `city`, `platform`) VALUES(:ip, :city, :platform)')->execute([
    'ip' => $post['ip'],
    'city' => $post['city'],
    'platform' => $post['platform'],
]);
$locationId = $pdo->lastInsertId();
session_start();
if (!empty($_SESSION['user']['id'])) {
    $userStmt = $pdo->prepare('SELECT * FROM `users` WHERE `id` = ?');
    $userStmt->execute([$_SESSION['user']['id']]);
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);
    if (empty($user)) {
        throw new RuntimeException('User from session not found');
    }

    $pdo->prepare('INSERT INTO `users_locations` (`user_id`, `location_id`) VALUES (:user_id, :location_id)')
        ->execute([
            'user_id' => $_SESSION['user']['id'],
            'location_id' => $locationId
        ]);
}
