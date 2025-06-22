<?php
session_start();
require_once __DIR__ . '/conexion.php';

// Verificar si la sesión está iniciada (comprobando si existe un valor en $_SESSION)
if (!isset($_SESSION['idusuario'])) {
    // Si no hay sesión, redirigir al login
    header('Location: login.html');
    exit;
}
// Mensaje de bienvenida
$welcome_message = htmlspecialchars($_SESSION['nombre']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/chart.css">
    <link rel="stylesheet" href="css/sesion.css">
    <title>Comparación de Cosecha y Predicción 2025</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <script src="js/script.js"></script>
    <script>
        // Agregar el header
        document.body.prepend(Components.createHeader());
    </script>



    <div class="session-card-wrapper">
        <div class="session-card">
            <div class="session-card-logo">
                <img src="img/sesion.png" alt="Logo de sesión" width="30" height="30">
            </div>
            <div class="session-card-info">
                <p class="welcome-message"><?php echo $welcome_message; ?></p>
                <a href="cerrar_sesion.php" class="logout-button">Cerrar sesión</a>
            </div>
            <!-- Botón de Cerrar sesión -->

        </div>
    </div>



    <div class="grafico-container">
        <div class="grafico-item">
            <canvas id="chart"></canvas>
        </div>
        <div class="grafico-item-table">
            <table border="1" id="dataTable">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>



    <div class="weather-info-container">
        <!-- Contenedor izquierdo -->
        <div class="weather-left">
            <h2>Promedio de Humedad y Temperatura</h2>

            <div class="chart-container">
                <h3>Humedad Mensual (%)</h3>
                <canvas id="humidityChart"></canvas>
            </div>

            <div class="chart-container">
                <h3>Temperatura Mensual (°C)</h3>
                <canvas id="temperatureChart"></canvas>
            </div>
        </div>


        <!-- Contenedor derecho (grafico-itemm reducido a un cuadrado) -->
        <div class="grafico-itemm">
            <div class="section">
                <h2>Clima en Guayaquil</h2>
                <p class="temp">--°C</p>
                <p class="desc">Cargando...</p>
                <!-- Información adicional si deseas -->
            </div>
        </div>
    </div>






    <script>
        const API_KEY = "6d0a7e8f02d4890cb8917d785d7fa405"; // Reemplázalo con tu API Key
        const URL = `https://api.openweathermap.org/data/2.5/weather?q=Guayaquil&units=metric&appid=${API_KEY}&lang=es`;

        async function getWeather() {
            try {
                const response = await fetch(URL);
                const data = await response.json();
                document.querySelector(".temp").innerText = `${data.main.temp}°C`;
                document.querySelector(".desc").innerText = data.weather[0].description;
            } catch (error) {
                document.querySelector(".desc").innerText = "Error al obtener el clima.";
            }
        }
        getWeather();

        // Función para mostrar mensajes de error
        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.style.backgroundColor = '#ffebee';
            errorDiv.style.color = '#c62828';
            errorDiv.style.padding = '15px';
            errorDiv.style.margin = '15px 0';
            errorDiv.style.borderRadius = '4px';
            errorDiv.innerHTML = `<strong>Error:</strong> ${message}`;

            // Insertar antes del gráfico
            document.querySelector('.grafico-container').prepend(errorDiv);
        } // Obtener datos de la API con mejor manejo de errores
        fetch('api.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error de red: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .catch(error => {
                showError(`No se pudieron obtener los datos: ${error.message}`);
                console.error('Error en fetch:', error);
                return {}; // Devolver objeto vacío para evitar errores posteriores
            })
            .then(data => {
                // Verificar si tenemos datos válidos
                if (!data || data.error) {
                    if (data && data.error) {
                        showError(`Error del servidor: ${data.message}`);
                    }
                    return; // Salir si no hay datos o hay un error
                }

                // Meses en formato de texto
                const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; // Extraemos las etiquetas y valores de la predicción para 2025
                const predictedValues = [];
                // Inicializa array con 12 valores en cero (uno por mes)
                for (let i = 0; i < 12; i++) {
                    predictedValues[i] = 0;
                }

                // Si tenemos datos de predicción, los colocamos en las posiciones correctas
                if (data.prediction && data.prediction[2025]) {
                    for (const mes in data.prediction[2025]) {
                        if (mes >= 1 && mes <= 12) {
                            predictedValues[mes - 1] = data.prediction[2025][mes];
                        }
                    }
                }

                // Extraemos los valores de la cosecha real para 2025
                const cosecha2025Values = [];
                // Inicializa array con 12 valores en cero (uno por mes)
                for (let i = 0; i < 12; i++) {
                    cosecha2025Values[i] = 0;
                }

                // Si tenemos datos históricos para 2025, los colocamos en las posiciones correctas
                if (data.historical_2025 && Array.isArray(data.historical_2025)) {
                    data.historical_2025.forEach(item => {
                        if (item && typeof item.mes === 'number' && item.mes >= 1 && item.mes <= 12) {
                            cosecha2025Values[item.mes - 1] = item.cantidad;
                        }
                    });
                }

                console.log("Datos procesados para la gráfica:", {
                    predictedValues,
                    cosecha2025Values,
                    raw: data
                });

                // Graficar la comparación entre la predicción y la cosecha actual de 2025
                new Chart(document.getElementById('chart'), {
                    type: 'line',
                    data: {
                        labels: months, // Usamos los meses como etiquetas
                        datasets: [{
                                label: 'Predicción 2025',
                                data: predictedValues,
                                borderColor: 'red', // Color de la línea de predicción
                                borderDash: [5, 5], // Línea discontinua
                                fill: false, // Sin relleno bajo la línea
                            },
                            {
                                label: 'Cosecha Real 2025',
                                data: cosecha2025Values,
                                borderColor: 'green', // Color de la línea de cosecha
                                fill: false, // Sin relleno bajo la línea
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                }); // Mostrar los datos de 2025 en la tabla
                const tableBody = document.querySelector("#dataTable tbody");
                // Limpiar la tabla primero
                tableBody.innerHTML = '';

                // Verificar si tenemos datos de 2025
                if (data.historical_2025 && Array.isArray(data.historical_2025) && data.historical_2025.length > 0) {
                    data.historical_2025.forEach(item => {
                        if (item && item.mes && typeof item.mes === 'number' && item.cantidad) {
                            const monthIndex = parseInt(item.mes) - 1;
                            if (monthIndex >= 0 && monthIndex < months.length) {
                                const row = `<tr><td>${months[monthIndex]}</td><td>${item.cantidad}</td></tr>`;
                                tableBody.innerHTML += row;
                            }
                        }
                    });
                } else {
                    // Si no hay datos, mostrar mensaje
                    tableBody.innerHTML = '<tr><td colspan="2">No hay datos disponibles para 2025</td></tr>';
                }

                // Mensaje de predicción
                document.getElementById("prediction").innerText = `Comparación entre la predicción y la cosecha real de 2025.`;
            });




        document.addEventListener("DOMContentLoaded", function() {
            // Datos de humedad y temperatura
            const labels = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
            const humedadData = [75, 78, 80, 85, 82, 81, 79, 77, 76, 74, 73, 72]; // Datos de ejemplo
            const temperaturaData = [28, 29, 30, 31, 30, 29, 28, 27, 26, 25, 24, 23]; // Datos de ejemplo

            // Configuración de gráficos
            function crearGrafico(id, label, data, color) {
                const ctx = document.getElementById(id).getContext("2d");
                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: data,
                            borderColor: color,
                            backgroundColor: color.replace("1)", "0.2)"), // Color con opacidad
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: label
                                }
                            }
                        }
                    }
                });
            }

            // Crear los gráficos
            crearGrafico("humidityChart", "Humedad (%)", humedadData, "rgba(0, 123, 255, 1)");
            crearGrafico("temperatureChart", "Temperatura (°C)", temperaturaData, "rgba(255, 99, 132, 1)");




        });
    </script>
    <script>
        // Agregar el footer
        document.body.append(Components.createFooter());
    </script>
</body>

</html>