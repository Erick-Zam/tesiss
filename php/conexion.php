<?php
$conexion = mysqli_connect("fdb1030.awardspace.net", "4550502_prueba", "Hosting28147*", "4550502_prueba");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    error_log("Conexión exitosa a la base de datos.");
}

function cerrar_conexion() {
    global $conexion;
    mysqli_close($conexion);
    return null;
}
