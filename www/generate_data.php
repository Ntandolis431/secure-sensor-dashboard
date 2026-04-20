<?php
header('Content-Type: text/plain; charset=utf-8');

$host = "db";
$dbname = "sensor_data";
$username = "sensor_user";
$password = "sensor_pass";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Wider ranges: temperature 0–100 °C, humidity 0–100 %
    $temperature = rand(0, 1000) / 10;    // 0.0 to 100.0
    $humidity = rand(0, 1000) / 10;       // 0.0 to 100.0

    $stmt = $pdo->prepare("INSERT INTO sensor_readings (temperature, humidity) VALUES (:temp, :hum)");
    $stmt->execute([':temp' => $temperature, ':hum' => $humidity]);

    echo "Temperature: " . number_format($temperature, 1) . " °C, Humidity: " . number_format($humidity, 1) . " %";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>