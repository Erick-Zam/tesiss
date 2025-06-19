<?php
session_start();
require_once 'php/conexion.php';

// Verificar si la sesión está activa, de lo contrario redirigir al login
if (!isset($_SESSION['idusuario'])) {
    // Redirigir al login si no hay sesión
    header('Location: ../login.html');
    exit;
}

echo "<div id='welcome-container'>";
echo "<h1>Arrocera Familia y Maria</h1>";

// Mostrar el mensaje de bienvenida si está iniciada la sesión
$welcome_message = isset($_GET['welcome']) ? htmlspecialchars($_GET['welcome']) : "Bienvenido, " . htmlspecialchars($_SESSION['nombre']);
echo "<p id='welcome-message'>$welcome_message</p>";

echo "</div>";

cerrar_conexion();
?>

<script>
    setTimeout(() => {
        window.location.href = "mapa.php"; // Redirige después de 3 segundos
    }, 3000);
</script>

<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    #welcome-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    h1, p {
        margin: 10px 0;
    }
</style>
