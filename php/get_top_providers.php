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

// Consulta para obtener los 5 proveedores con mayor cantidad adquirida anualmente
$sql = "SELECT nombre, cantidad_adquirida_anual FROM proveedores ORDER BY cantidad_adquirida_anual DESC LIMIT 5";
$result = $conn->query($sql);

$providers = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}

// Devolver los datos en formato JSON
echo json_encode($providers);

// Cerrar la conexión
$conn->close();
?>