<?php
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

// Consulta para obtener los proveedores con sus coordenadas
$sql = "
    SELECT 
        pr.id AS id,
        pr.nombre,
        pr.correo,
        pr.telefono,
        pr.cantidad_adquirida_anual,
        g.latitud,
        g.longitud
    FROM proveedores pr
    JOIN geolocalizacion g ON pr.id = g.id
    WHERE g.latitud IS NOT NULL AND g.longitud IS NOT NULL
";

$result = $conn->query($sql);

$proveedores = array();

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $proveedores[] = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($proveedores);
?>
