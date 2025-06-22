<?php
// Incluye la configuración centralizada
require_once __DIR__ . '/../config.php';

// Obtener conexión usando la función centralizada
$conn = getConnection();

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $cantidad = htmlspecialchars($_POST['cantidad']);
    $latitud = htmlspecialchars($_POST['latitud']);
    $longitud = htmlspecialchars($_POST['longitud']);

    // Preparar la consulta SQL para insertar el proveedor
    $sql_proveedor = "INSERT INTO proveedores (nombre, correo, telefono, cantidad_adquirida_anual)
                     VALUES ('$nombre', '$correo', '$telefono', $cantidad)";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sql_proveedor) === TRUE) {
        // Obtener el ID del proveedor insertado
        $proveedor_id = $conn->insert_id;

        // Preparar la consulta SQL para insertar la geolocalización
        $sql_geolocalizacion = "INSERT INTO geolocalizacion (usuario, telefono, fecha, latitud, longitud)
                               VALUES ($proveedor_id, '$telefono', NOW(), $latitud, $longitud)";

        // Ejecutar la consulta y verificar si fue exitosa
        if ($conn->query($sql_geolocalizacion) === TRUE) {
            echo "Nuevo proveedor '$nombre' y su geolocalización agregados exitosamente.";
        } else {
            echo "Error al insertar geolocalización: " . $conn->error;
        }
    } else {
        echo "Error al insertar proveedor: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
