<?php
// Incluye la configuración centralizada
require_once __DIR__ . '/../config.php';

// Obtener conexión usando la función centralizada
$conexion = getConnection();

// Registrar conexión exitosa
error_log("Conexión exitosa a la base de datos.");

function cerrar_conexion()
{
    global $conexion;
    closeConnection($conexion);
    return null;
}
