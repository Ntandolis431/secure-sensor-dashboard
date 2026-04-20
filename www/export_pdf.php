<?php
require_once 'vendor/autoload.php'; // Composer autoload

use Dompdf\Dompdf;
use Dompdf\Options;

// Get date range
$start_date = $_GET['start_date'] ?? '';
$end_date   = $_GET['end_date'] ?? '';

if (empty($start_date) || empty($end_date)) {
    die('Missing start or end date.');
}

// Database connection
$host = "db";
$dbname = "sensor_data";
$username = "sensor_user";
$password = "sensor_pass";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        SELECT reading_time, temperature, humidity
        FROM sensor_readings
        WHERE DATE(reading_time) BETWEEN :start AND :end
        ORDER BY reading_time ASC
    ");
    $stmt->execute([':start' => $start_date, ':end' => $end_date]);
    $readings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Build HTML for PDF
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Sensor Data Report</title>
        <style>
            body { font-family: sans-serif; }
            h1 { color: #2c3e50; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
            th { background-color: #ecf0f1; }
            .footer { margin-top: 30px; font-size: 12px; color: #7f8c8d; }
        </style>
    </head>
    <body>
        <h1>Sensor Data Report</h1>
        <p>Date Range: ' . htmlspecialchars($start_date) . ' to ' . htmlspecialchars($end_date) . '</p>
        <p>Total Readings: ' . count($readings) . '</p>
        <table>
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Temperature (°C)</th>
                    <th>Humidity (%)</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($readings as $r) {
        $html .= '<tr>
            <td>' . htmlspecialchars($r['reading_time']) . '</td>
            <td>' . number_format($r['temperature'], 1) . '</td>
            <td>' . number_format($r['humidity'], 1) . '</td>
        </tr>';
    }

    $html .= '
            </tbody>
        </table>
        <div class="footer">Generated on ' . date('Y-m-d H:i:s') . '</div>
    </body>
    </html>';

    // Generate PDF
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output PDF
    $dompdf->stream("sensor_report_{$start_date}_to_{$end_date}.pdf", ["Attachment" => true]);

} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    echo "PDF generation error: " . $e->getMessage();
}
?>