<?php
session_start();
require_once 'conexion.php';

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();



// Redirigir al usuario a la página principal (index.php)
header('Location: index.php');
exit;
?>