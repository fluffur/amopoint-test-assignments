<?php
session_start();

if (empty($_SESSION['user'])) {
    header('Location: /');
    exit;
}

/** @var PDO $pdo */
$pdo = require_once __DIR__ . '/db.php';

// Получение данных для графика посещений по часам
$stmt = $pdo->prepare("SELECT `visited_at` as hour, COUNT(*) as count
    FROM locations  
    GROUP BY hour
    ORDER BY hour
");
$stmt->execute();
$visitsByHour = $stmt->fetchAll(PDO::FETCH_ASSOC);
array_walk($visitsByHour, function (&$value) {
    $value['hour'] = date('H:i', strtotime($value['hour']));
});
// For test
//$visitsByHour = [
//    ['hour' => '14:00', 'count' => 0],
//    ['hour' => '15:00', 'count' => 3],
//    ['hour' => '16:00', 'count' => 5],
//    ['hour' => '17:00', 'count' => 6],
//];

$stmt = $pdo->prepare('
    SELECT city, COUNT(*) as count
    FROM locations
    GROUP BY city
');
$stmt->execute();
$visitsByCity = $stmt->fetchAll(PDO::FETCH_ASSOC);
// For test
//$visitsByCity = [
//        ['city' => 'Novosibirsk', 'count' => 3],
//        ['city' => 'Almaty', 'count' => 1],
//        ['city' => 'Moscow', 'count' => 2],
//];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика посещений</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container">
    <p><a href="/">Домой</a></p>

    <h1>Статистика посещений</h1>

    <h2>Посещения по часам</h2>
    <canvas id="visitsByHourChart" width="400" height="200"></canvas>


    <h2>Посещения по городам</h2>
    <canvas id="visitsByCityChart" width="400" height="200"></canvas>


</div>

<script>
    const showHoursChart = () => {
        const ctx = document.getElementById('visitsByHourChart').getContext('2d');
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($visitsByHour, 'hour')); ?>,
                datasets: [{
                    label: 'Посещения по часам',
                    data: <?= json_encode(array_column($visitsByHour, 'count')); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                }
            }
        });
    }


    const showCitiesByVisitsChart = () => {
        const ctx = document.getElementById('visitsByCityChart').getContext('2d');
        return new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($visitsByCity, 'city')); ?>,
                datasets: [{
                    label: 'Посещения по городам',
                    data: <?php echo json_encode(array_column($visitsByCity, 'count')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    }
    showCitiesByVisitsChart();
    showHoursChart();
</script>
</body>
</html>