<?php
header('Content-Type: application/json');
if (!isset($_GET['datetime'])) {
    echo json_encode(['error' => 'Missing datetime']);
    exit;
}
$host = "db";
$dbname = "sensor_data";
$user = "sensor_user";
$pass = "sensor_pass";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("
        SELECT reading_time, temperature, humidity,
               ABS(TIMESTAMPDIFF(SECOND, reading_time, :dt)) AS diff
        FROM sensor_readings
        ORDER BY diff ASC
        LIMIT 1
    ");
    $stmt->execute([':dt' => $_GET['datetime']]);
    $reading = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($reading) {
        echo json_encode($reading);
    } else {
        echo json_encode(['error' => 'No readings found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>