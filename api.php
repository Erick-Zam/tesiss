<?php
header('Content-Type: application/json');

$servername = "fdb1030.awardspace.net";
$username = "4550502_prueba";
$password = "Hosting28147*";
$dbname = "4550502_prueba";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Fallo en la conexión"]));
}

// Consulta para obtener la cantidad de productos por mes para todos los años (para la predicción)
$sql = "SELECT YEAR(fecha_cosecha) AS anio, MONTH(fecha_cosecha) AS mes, SUM(cantidad) AS cantidad 
        FROM detalle_producto 
        GROUP BY anio, mes 
        ORDER BY anio, mes";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
// Consulta para obtener la cantidad de productos por mes en 2025
$sql_2025 = "SELECT MONTH(fecha_cosecha) AS mes, SUM(cantidad) AS cantidad 
             FROM detalle_producto 
             WHERE YEAR(fecha_cosecha) = 2025 
             GROUP BY mes 
             ORDER BY mes ASC";
$result_2025 = $conn->query($sql_2025);
$data_2025 = [];
while ($row_2025 = $result_2025->fetch_assoc()) {
    $data_2025[] = $row_2025;
}

$conn->close();

// Algoritmo de predicción (Media Móvil Simple)
$historicalData = [];
foreach ($data as $row) {
    $historicalData[$row['anio']][$row['mes']] = $row['cantidad'];
}

$predictedData = [];
for ($mes = 1; $mes <= 12; $mes++) {
    $sum = 0;
    $count = 0;
    foreach ($historicalData as $anio => $meses) {
        if (isset($meses[$mes])) {
            $sum += $meses[$mes];
            $count++;
        }
    }
    $predictedData[2025][$mes] = $count > 0 ? round($sum / $count, 2) : 0;
}

$response = [
    "historical" => $data,
    "prediction" => $predictedData,
    "historical_2025" => $data_2025 // Incluye los datos de 2025 en la respuesta
];

echo json_encode($response);
?>
