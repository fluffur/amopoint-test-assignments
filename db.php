<?php

require_once __DIR__ . '/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$dbUser = $_ENV['DB_USER'];
$dbPassword = $_ENV['DB_PASSWORD'];

$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname", $dbUser, $dbPassword
);


$pdo->prepare('
CREATE TABLE IF NOT EXISTS `locations`
(
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `ip`           VARCHAR(50)  NOT NULL UNIQUE,
    `city`         VARCHAR(100) NOT NULL,
    `platform`     VARCHAR(300) NOT NULL,
    `visited_at`   DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
')->execute();



$pdo->prepare('
CREATE TABLE IF NOT EXISTS `users`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `email`    VARCHAR(300) NOT NULL UNIQUE,
    `name`     VARCHAR(300) NOT NULL,
    `password` VARCHAR(300) NOT NULL
);
')->execute();


$pdo->prepare('
CREATE TABLE IF NOT EXISTS `users_locations`
(
    `user_id`     INT NOT NULL,
    `location_id` INT NOT NULL,
    PRIMARY KEY (`user_id`, `location_id`)
);
'
)->execute();


return $pdo;