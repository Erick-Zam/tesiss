<?php
session_start();
require_once 'conexion.php';
require_once 'header.php';

echo "<h1>Arrocera Familia y Maria</h1>";

if (isset($_SESSION['idusuario'])) {
    // Display welcome message if present in URL
    if (isset($_GET['welcome'])) {
        echo htmlspecialchars($_GET['welcome']);
    } else {
        echo "Bienvenido, " . $_SESSION['nombre'];
    }
    echo "<a href='php/cerrar_sesion.php'>Cerrar sesión</a>";
} else {
    echo "<a href='login.html'>Iniciar sesión</a>";
}

require_once 'footer.php';
cerrar_conexion();
?>
