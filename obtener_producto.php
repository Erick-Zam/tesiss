<?php
include 'conexion.php';

// Verificar si 'id' está presente y es un valor numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Escapar el valor de $id para prevenir inyecciones SQL
    $id = $conn->real_escape_string($id);    // Realizar la consulta
    $sql = "SELECT id, cantidad, precio, tipo, fecha_cosecha, fecha_envio, lote FROM detalle_producto WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        // Retornar los datos del producto en formato JSON
        echo json_encode($row);
    } else {
        // Si no se encuentra el producto, enviar un mensaje de error
        echo json_encode(["error" => "No encontrado"]);
    }
} else {
    // Si no se pasa un 'id' válido, enviar un mensaje de error
    echo json_encode(["error" => "ID no proporcionado o inválido"]);
}
