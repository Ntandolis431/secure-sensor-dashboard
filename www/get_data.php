<?php
header('Content-Type: application/json');

$host = "db";
$dbname = "sensor_data";
$username = "sensor_user";
$password = "sensor_pass";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT reading_time, temperature, humidity FROM sensor_readings ORDER BY id DESC LIMIT 50");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rows = array_reverse($rows);

    $timestamps = array_column($rows, 'reading_time');
    $temperatures = array_column($rows, 'temperature');
    $humidities = array_column($rows, 'humidity');

    echo json_encode([
        'labels' => $timestamps,
        'temperatures' => $temperatures,
        'humidities' => $humidities
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>