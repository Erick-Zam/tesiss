<?php
    session_start();

    // Verificar si la sesión está iniciada (comprobando si existe un valor en $_SESSION)
    if (!isset($_SESSION['idusuario'])) {
        // Si no hay sesión, redirigir al login
        header('Location: ../login.html');
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
    <link rel="stylesheet" href="css/pruebamap.css" />
    <link rel="stylesheet" href="css/sesion.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js"></script>



    

    <title>Mapa de Proveedores en Ecuador</title>

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




    <div class="container">
        <h1>Mapa de Proveedores en Ecuador</h1>
        <!--abla flotante -->
        <div id="providersTable" style="display: none;">
            <h4 class="titletop">Top Proveedores</h4>
            <table id="providersList">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Cantidad Anual</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se llenarán con JavaScript -->
                </tbody>
            </table>
        </div>
        <div id="map"></div>
    </div>

    <div class="container">
        <!-- Botón para abrir el modal -->
        <center>
            <button class="btn btn-add" id="openModalBtn">Agregar Proveedor</button>

            
        </center>
    </div>
    <div class="container">
        <!-- Lista de proveedores -->
        <div class="info-container">
            <h2>Proveedores</h2>
            <ul id="provider-list" class="provider-list">
                <!-- Aquí se generarán los proveedores dinámicamente -->
            </ul>
        </div>
    </div>



    <!-- Modal para Actualizar Proveedor --------------------------------------------------------------------------------->
    <!-- Modal de Edición -->

    <!-- Modal para Actualizar Proveedor --------------------------------------------------------------------------------->


    <!-- Modal -->
    <div id="addProviderModal" class="modal">
        <div class="modal-content">
            <span id="closeModalBtn" class="close">&times;</span>
            <h2>Agregar Nuevo Proveedor</h2>
            <form id="addProviderForm">
                <!-- Campos del formulario -->
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                <input type="email" id="correo" name="correo" placeholder="Correo" required>
                <input type="text" id="telefono" name="telefono" placeholder="Teléfono" required>
                <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                <input type="number" id="latitud" name="latitud" placeholder="Latitud" step="any" required>
                <input type="number" id="longitud" name="longitud" placeholder="Longitud" step="any" required>
                <button class="btn btn-save" type="submit">Guardar Proveedor</button>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([-1.8312, -78.1834], 6); // Centro de Ecuador

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var heatData = []; // Array para almacenar los puntos del mapa de calor

            fetch('php/get_proveedores.php')
                .then(response => response.json())
                .then(proveedores => {
                    var providerList = document.getElementById('provider-list');
                    var heatData = []; // Array para almacenar los puntos del mapa de calor

                    proveedores.forEach(function(provider) {
                        // Convertir latitud y longitud a números flotantes
                        var lat = parseFloat(provider.latitud);
                        var lng = parseFloat(provider.longitud);

                        // Verificar si las coordenadas son válidas y la cantidad adquirida es un número
                        if (!isNaN(lat) && !isNaN(lng) && provider.cantidad_adquirida_anual) {
                            // Crear el marcador para el proveedor en el mapa
                            var marker = L.marker([lat, lng]).addTo(map)
                                .bindPopup(`<b>${provider.nombre}</b><br>Email: ${provider.correo}<br>Cantidad Anual: ${provider.cantidad_adquirida_anual} unidades<br>Tel: ${provider.telefono}`);

                            // Agregar los datos al mapa de calor: lat, lng, cantidad adquirida como intensidad
                            heatData.push([lat, lng, parseInt(provider.cantidad_adquirida_anual)]);
                        } else {
                            console.log("Datos inválidos para el proveedor:", provider);
                        }

                        // Crear el item de lista para mostrar al proveedor
                        var listItem = document.createElement('li');
                        listItem.classList.add('provider-item');
                        listItem.textContent = provider.nombre;
                        listItem.onclick = function() {
                            toggleDetails(provider.id);
                        };

                        // Crear el contenedor de detalles
                        var detailsDiv = document.createElement('div');
                        detailsDiv.classList.add('provider-details');
                        detailsDiv.id = 'details-' + provider.id;
                        detailsDiv.innerHTML = `
                            <b>Nombre:</b> ${provider.nombre}<br>
                            <b>Correo:</b> ${provider.correo}<br>
                            <b>Cantidad Adquirida Anualmente:</b> ${provider.cantidad_adquirida_anual} unidades<br>
                            <b>Teléfono:</b> ${provider.telefono}
                        `;

                        // Agregar el contenedor de detalles al elemento de la lista
                        listItem.appendChild(detailsDiv);
                        providerList.appendChild(listItem);
                    });

                    console.log("Puntos de calor:", heatData); // Revisa los datos antes de agregarlos al mapa

                    // Verificar si hay datos y agregar el mapa de calor
                    if (heatData.length > 0) {
                        L.heatLayer(heatData, {
                            radius: 50,  // Ajustar el tamaño del radio según sea necesario
                            blur: 30,    // Ajuste de difuminado
                            maxZoom: 20,  // Ajuste del nivel máximo de zoom
                            max: 1,       // Máxima intensidad (ajústalo según el rango de tus datos)
                            gradient: {
                                0.0: 'blue',    // Baja intensidad
                                0.2: 'lime',    // Intensidad media
                                0.4: 'yellow',  // Alta intensidad
                                0.6: 'orange',  // Muy alta intensidad
                                1.0: 'red'      // Máxima intensidad
                            }
                        }).addTo(map);

                    } else {
                        console.log("No hay datos para el mapa de calor.");
                    }
                })
                .catch(error => console.error('Error al cargar los proveedores:', error));




            // Función para mostrar detalles del proveedor
            function toggleDetails(providerId) {
                var detailsElement = document.getElementById('details-' + providerId);
                detailsElement.style.display = detailsElement.style.display === 'none' ? 'block' : 'none';
            }

            // Obtener elementos del DOM
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const addProviderModal = document.getElementById('addProviderModal');
            const addProviderForm = document.getElementById('addProviderForm');

            // Abrir el modal
            openModalBtn.addEventListener('click', () => {
                addProviderModal.style.display = 'flex';
            });

            // Cerrar el modal
            closeModalBtn.addEventListener('click', () => {
                addProviderModal.style.display = 'none';
            });


            document.getElementById('addProviderForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Evita el envío tradicional del formulario

                const formData = new FormData(this);

                fetch('php/guardar_proveedor.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        // Si la respuesta no es exitosa, lanzar un error
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.text(); // O response.json() si el servidor devuelve JSON
                })
                .then(data => {
                    // Mostrar el mensaje recibido del servidor
                    alert(data);
                    location.reload();
                    // Opcional: cerrar el modal después de enviar el formulario
                    document.getElementById('addProviderModal').style.display = 'none';
                    // Opcional: recargar la lista de proveedores o agregar el nuevo proveedor a la lista
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Mostrar un mensaje de error genérico
                    alert('Ocurrió un error al enviar el formulario.');
                });

            });



            // Función para cargar los proveedores desde el PHP
            function loadProviders() {
                // Usando AJAX para obtener los datos de get_top_providers.php
                fetch('php/get_top_providers.php')
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.getElementById('providersList').getElementsByTagName('tbody')[0];
                        tableBody.innerHTML = ''; // Limpiar contenido previo

                        // Añadir los proveedores a la tabla
                        data.forEach(provider => {
                            const row = tableBody.insertRow();
                            const nameCell = row.insertCell(0);
                            const quantityCell = row.insertCell(1);

                            nameCell.textContent = provider.nombre;
                            quantityCell.textContent = provider.cantidad_adquirida_anual;
                        });

                        // Mostrar la tabla flotante
                        document.getElementById('providersTable').style.display = 'block';
                    })
                    .catch(error => console.error('Error al cargar los proveedores:', error));
            }

            // Llamar a la función para cargar los datos cuando la página esté lista
            window.onload = loadProviders;



        });




    </script>
    <script>
        // Agregar el footer
        document.body.append(Components.createFooter());
   </script>
</body>
</html>