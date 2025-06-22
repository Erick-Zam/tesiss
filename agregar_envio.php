<?php
include 'conexion.php';

$proveedor_id = $_POST['proveedor_id'];
$producto = $_POST['producto'];
$cantidad = $_POST['cantidad'];
$fecha_envio = $_POST['fecha_envio'];

// Insertar el envío en detalle_producto
$sql = "INSERT INTO detalle_producto (cantidad, tipo, fecha_envio, proveedor_id) 
        VALUES ('$cantidad', '$producto', '$fecha_envio', '$proveedor_id')";

if ($conn->query($sql) === TRUE) {
    echo "Envío agregado correctamente.";
} else {
    echo "Error al agregar: " . $conn->error;
}
