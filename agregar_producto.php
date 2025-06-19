<?php 
include 'conexion.php';

// Recoger los datos del formulario
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$proveedor_id = $_POST['proveedor_id'];
$fecha_cosecha = $_POST['fecha_cosecha'];
$fecha_envio = $_POST['fecha_envio'];
$lote = $_POST['lote'];

// SQL para insertar el nuevo producto
$sql = "INSERT INTO detalle_producto (cantidad, precio, tipo, proveedor_id, fecha_cosecha, fecha_envio, lote) 
        VALUES ('$cantidad', '$precio', '$tipo', '$proveedor_id', '$fecha_cosecha', '$fecha_envio', '$lote')";

if ($conn->query($sql) === TRUE) {
    echo "Producto agregado correctamente.";
} else {
    echo "Error al agregar: " . $conn->error;
}
?>
