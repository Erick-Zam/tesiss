<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);  // Convertir el ID a un número entero    // Preparar y ejecutar la consulta de eliminación
    $sql = "DELETE FROM detalle_producto WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto eliminado con éxito."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el producto."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido o ID no válido."]);
}

$conn->close();
