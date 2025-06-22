<?php
// Archivo para depurar problemas con la base de datos

// Mostrar errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir configuración centralizada
require_once __DIR__ . '/config.php';

echo "<h2>Información de Depuración</h2>";

try {
    // Intentar conectar a la base de datos
    $conn = getConnection();
    echo "<p style='color:green'>✓ Conexión a la base de datos establecida correctamente.</p>";    // Verificar si existen las tablas necesarias
    $tables = ['detalle_producto', 'detalle_envio', 'proveedores'];

    foreach ($tables as $table) {
        $sql = "SHOW TABLES LIKE '$table'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<p style='color:green'>✓ La tabla '$table' existe.</p>";

            // Contar registros en la tabla
            $count_sql = "SELECT COUNT(*) AS count FROM $table";
            $count_result = $conn->query($count_sql);
            $count_row = $count_result->fetch_assoc();
            echo "<p>- La tabla '$table' tiene {$count_row['count']} registros.</p>";

            // Mostrar algunos registros de ejemplo
            $sample_sql = "SELECT * FROM $table LIMIT 3";
            $sample_result = $conn->query($sample_sql);

            echo "<p>Muestra de registros:</p>";
            echo "<table border='1'><tr>";

            // Encabezados de la tabla
            $first_row = $sample_result->fetch_assoc();
            if ($first_row) {
                foreach ($first_row as $key => $value) {
                    echo "<th>$key</th>";
                }
                echo "</tr>";

                // Mostrar primer registro
                echo "<tr>";
                foreach ($first_row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";

                // Mostrar registros adicionales
                while ($row = $sample_result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='100'>No hay registros</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p style='color:red'>✗ La tabla '$table' no existe.</p>";
        }
    }

    // Verificar si las consultas específicas funcionan
    echo "<h3>Prueba de consultas específicas:</h3>";    // Consulta para obtener datos por año y mes
    $sql = "SELECT YEAR(fecha_cosecha) AS anio, MONTH(fecha_cosecha) AS mes, SUM(cantidad) AS cantidad 
            FROM detalle_producto 
            GROUP BY anio, mes 
            ORDER BY anio, mes";

    try {
        $result = $conn->query($sql);
        if ($result) {
            echo "<p style='color:green'>✓ La consulta de datos históricos funciona correctamente.</p>";
            echo "<p>Resultados: " . $result->num_rows . " filas.</p>";
        } else {
            echo "<p style='color:red'>✗ Error en la consulta de datos históricos: " . $conn->error . "</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>✗ Excepción en la consulta de datos históricos: " . $e->getMessage() . "</p>";
    }    // Consulta para obtener datos de 2025
    $sql_2025 = "SELECT MONTH(fecha_cosecha) AS mes, SUM(cantidad) AS cantidad 
                FROM detalle_producto 
                WHERE YEAR(fecha_cosecha) = 2025 
                GROUP BY mes 
                ORDER BY mes ASC";

    try {
        $result_2025 = $conn->query($sql_2025);
        if ($result_2025) {
            echo "<p style='color:green'>✓ La consulta de datos de 2025 funciona correctamente.</p>";
            echo "<p>Resultados: " . $result_2025->num_rows . " filas.</p>";
        } else {
            echo "<p style='color:red'>✗ Error en la consulta de datos de 2025: " . $conn->error . "</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>✗ Excepción en la consulta de datos de 2025: " . $e->getMessage() . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>✗ Error al conectar a la base de datos: " . $e->getMessage() . "</p>";
}
