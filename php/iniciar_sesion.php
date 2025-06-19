<?php
session_start();
require_once 'conexion.php';

// Establecer cabecera JSON
header('Content-Type: application/json');

if (isset($_POST['usuario']) && isset($_POST['clave'])) {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $query = "SELECT * FROM usuario WHERE (usuario = '$usuario' OR correo = '$usuario') AND clave = '$clave'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $_SESSION['idusuario'] = $fila['idusuario'];
        $_SESSION['nombre'] = $fila['nombre'];
        $_SESSION['correo'] = $fila['correo'];
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['estado'] = $fila['estado'];

        // Devolver mensaje en JSON
        echo json_encode(["success" => true, "message" => "Bienvenido, " . htmlspecialchars($fila['nombre']), "redirect" => "index.php"]);

    } else {
        echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
}

cerrar_conexion();
?>
