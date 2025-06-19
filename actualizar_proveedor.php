<?php
// Datos de conexión a la base de datos
$servername = "fdb1030.awardspace.net";
$username = "4550502_prueba";
$password = "Hosting28147*";
$dbname = "4550502_prueba";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $cantidad = htmlspecialchars($_POST['cantidad']);
    $latitud = htmlspecialchars($_POST['latitud']);
    $longitud = htmlspecialchars($_POST['longitud']);

    // Preparar la consulta SQL para actualizar el proveedor
    $sql_proveedor = "UPDATE proveedores SET nombre='$nombre', correo='$correo', telefono='$telefono', cantidad_adquirida_anual=$cantidad WHERE id=$id";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sql_proveedor) === TRUE) {
        // Preparar la consulta SQL para actualizar la geolocalización
        $sql_geolocalizacion = "UPDATE geolocalizacion SET latitud=$latitud, longitud=$longitud WHERE usuario=$id";

        // Ejecutar la consulta y verificar si fue exitosa
        if ($conn->query($sql_geolocalizacion) === TRUE) {
            echo "Proveedor '$nombre' y su geolocalización actualizados exitosamente.";
        } else {
            echo "Error al actualizar geolocalización: " . $conn->error;
        }
    } else {
        echo "Error al actualizar proveedor: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
