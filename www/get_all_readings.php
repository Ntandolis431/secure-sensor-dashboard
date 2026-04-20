<?php
header('Content-Type: application/json');
$host = "db";
$dbname = "sensor_data";
$user = "sensor_user";
$pass = "sensor_pass";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT reading_time, temperature, humidity FROM sensor_readings ORDER BY reading_time ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>