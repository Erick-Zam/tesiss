<?php

/**
 * Archivo de configuración central para la base de datos
 * Cambia estos valores según el entorno donde despliegues la aplicación
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost'); // Cambia a 'fdb1030.awardspace.net' si despliegas en Awardspace
define('DB_PORT', '3306');      // Puerto MySQL, normalmente 3306
define('DB_USER', 'erick');     // Cambia a '4550502_prueba' si despliegas en Awardspace
define('DB_PASS', 'Evimu997261'); // Cambia a 'Hosting28147*' si despliegas en Awardspace
define('DB_NAME', '4550502_prueba');
define('DB_CHARSET', 'utf8mb4');

// Función para crear conexión de manera consistente en toda la aplicación
function getConnection()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Establecer el conjunto de caracteres
    $conn->set_charset(DB_CHARSET);

    return $conn;
}

// Función para cerrar la conexión
function closeConnection($conn)
{
    if ($conn) {
        $conn->close();
    }
}
