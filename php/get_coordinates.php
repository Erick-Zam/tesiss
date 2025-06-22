<?php
// Incluye la configuración centralizada
require_once __DIR__ . '/../config.php';

// Obtener conexión usando la función centralizada
$conn = getConnection();

$sql = "SELECT id, usuario, correo, telefono, cantidad_adquirida_anual, latitud, longitud FROM proveedores WHERE latitud IS NOT NULL AND longitud IS NOT NULL";
$result = $conn->query($sql);

$usuarios = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

echo json_encode(["success" => true, "usuarios" => $usuarios]);

$conn->close();
