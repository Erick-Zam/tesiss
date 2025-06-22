<?php
include 'conexion.php';

$id = $_POST['id'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$fecha_cosecha = $_POST['fecha_cosecha'];
$fecha_envio = $_POST['fecha_envio'];
$lote = $_POST['lote'];

$sql = "UPDATE detalle_producto 
        SET cantidad = '$cantidad', precio = '$precio', tipo = '$tipo', fecha_cosecha = '$fecha_cosecha', 
            fecha_envio = '$fecha_envio', lote = '$lote' 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Producto actualizado correctamente.";
} else {
    echo "Error al actualizar: " . $conn->error;
}
