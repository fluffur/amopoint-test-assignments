<?php

// На сервере необходим endpoint получения IP для обхода CORS
// Пример:

header('Content-Type: application/json');

$url = 'https://ipinfo.io/json';
$response = file_get_contents($url);

echo $response;
