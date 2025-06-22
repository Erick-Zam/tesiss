<?php
header('Content-Type: application/json');

// Habilitar manejo de errores para depuración
ini_set('display_errors', 1); // Activar salida de errores para depuración
error_reporting(E_ALL); // Reportar todos los errores

try {
    // Incluye la configuración centralizada
    require_once __DIR__ . '/config.php';

    // Obtener conexión usando la función centralizada
    $conn = getConnection();

    // Verificar si las tablas necesarias existen
    $tabla_productos = $conn->query("SHOW TABLES LIKE 'productos'");
    if (!$tabla_productos || $tabla_productos->num_rows == 0) {
        throw new Exception("La tabla 'productos' no existe en la base de datos");
    }

    // Mostrar datos de la tabla productos
    $debug_productos = "SELECT * FROM productos LIMIT 5";
    $result_debug = $conn->query($debug_productos);

    $productos_muestra = [];
    if ($result_debug) {
        while ($row = $result_debug->fetch_assoc()) {
            $productos_muestra[] = $row;
        }
    }

    // Consulta para obtener la cantidad de productos por mes para todos los años (para la predicción)
    $sql = "SELECT YEAR(fecha_cosecha) AS anio, MONTH(fecha_cosecha) AS mes, SUM(cantidad) AS cantidad 
            FROM productos 
            GROUP BY anio, mes 
            ORDER BY anio, mes";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Consulta para obtener la cantidad de productos por mes en 2025
    $sql_2025 = "SELECT MONTH(fecha_cosecha) AS mes, SUM(cantidad) AS cantidad 
                FROM productos 
                WHERE YEAR(fecha_cosecha) = 2025 
                GROUP BY mes 
                ORDER BY mes ASC";
    $result_2025 = $conn->query($sql_2025);
    if (!$result_2025) {
        throw new Exception("Error en la consulta SQL 2025: " . $conn->error);
    }

    $data_2025 = [];
    while ($row_2025 = $result_2025->fetch_assoc()) {
        // Asegurarse de que los datos son del tipo correcto
        $row_2025['mes'] = (int)$row_2025['mes'];
        $row_2025['cantidad'] = (float)$row_2025['cantidad'];
        $data_2025[] = $row_2025;
    }

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

    // Añadir información de depuración
    $response = [
        "db_info" => [
            "connection_successful" => true,
            "productos_muestra" => $productos_muestra
        ],
        "historical" => $data,
        "prediction" => $predictedData,
        "historical_2025" => $data_2025,
        "debug_info" => [
            "tiene_datos_2025" => !empty($data_2025),
            "cantidad_datos_2025" => count($data_2025),
            "formato_2025" => is_array($data_2025) ? "array" : gettype($data_2025)
        ]
    ];

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Devolver la respuesta en formato JSON
    echo json_encode($response);
} catch (Exception $e) {
    // En caso de error, devolver un mensaje de error en formato JSON
    http_response_code(500); // Establecer código de estado HTTP 500 (Error Interno del Servidor)
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage(),
        "file" => $e->getFile(),
        "line" => $e->getLine()
    ]);

    // Registrar el error en el log del servidor
    error_log("Error en API Debug: " . $e->getMessage());
}
