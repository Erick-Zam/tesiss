<?php
$servername = "fdb1030.awardspace.net";
$username = "4550502_prueba";
$password = "Hosting28147*";
$dbname = "4550502_prueba";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Error de conexión"]));
}

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
?>
