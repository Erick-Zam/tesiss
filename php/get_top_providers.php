<?php
// Incluye la configuración centralizada
require_once __DIR__ . '/../config.php';

// Obtener conexión usando la función centralizada
$conn = getConnection();

// Consulta para obtener los 5 proveedores con mayor cantidad adquirida anualmente
$sql = "SELECT nombre, cantidad_adquirida_anual FROM proveedores ORDER BY cantidad_adquirida_anual DESC LIMIT 5";
$result = $conn->query($sql);

$providers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}

// Devolver los datos en formato JSON
echo json_encode($providers);

// Cerrar la conexión
$conn->close();
