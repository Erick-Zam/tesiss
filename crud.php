<?php
   session_start();
   require_once 'conexion.php';

   // Verificar si la sesión está activa, de lo contrario redirigir al login
   if (!isset($_SESSION['idusuario'])) {
       // Redirigir al login si no hay sesión
       header('Location: ../login.html');
       exit;
   }

// Obtener la lista de proveedores
$sql_proveedores = "SELECT id, nombre FROM proveedores";
$result_proveedores = $conn->query($sql_proveedores);

// Obtener la lista de todos los productos
$sql_all = "SELECT dp.id, dp.cantidad, dp.precio, dp.tipo, dp.fecha_cosecha, dp.fecha_envio, dp.lote, p.nombre AS proveedor
            FROM detalle_producto dp
            LEFT JOIN proveedores p ON dp.proveedor_id = p.id";

// Obtener la lista de productos del año 2025
$sql_2025 = "SELECT dp.id, dp.cantidad, dp.precio, dp.tipo, dp.fecha_cosecha, dp.fecha_envio, dp.lote, p.nombre AS proveedor
             FROM detalle_producto dp
             LEFT JOIN proveedores p ON dp.proveedor_id = p.id
             WHERE YEAR(dp.fecha_cosecha) = 2025";

$result_all = $conn->query($sql_all);
$result_2025 = $conn->query($sql_2025);
// Mensaje de bienvenida
$welcome_message = htmlspecialchars($_SESSION['nombre']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Detalle Producto</title>
    <link rel="stylesheet" href="css/crud.css" />
    <link rel="stylesheet" href="css/sesion.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<style>
    #barcodeContainer img {
        max-width: 100%;  /* Asegura que la imagen se ajuste al contenedor */
        height: auto;     /* Mantiene la proporción de la imagen */
    }
</style>
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
<body>
    <script src="js/script.js"></script>
    <script>
        // Agregar el header
        document.body.prepend(Components.createHeader());
    </script>
    <div class="contenedor-principal mt-5">
        <h2>Detalle Producto</h2>

        <!-- Botón para abrir el modal de agregar producto -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Agregar Producto</button>

        <div class="table-responsive">
            <h3>Todos los Productos</h3>
            <table id="tablaProductos" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Tipo</th>
                        <th>Fecha Cosecha</th>
                        <th>Fecha Envío</th>
                        <th>Lote</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_all->fetch_assoc()): ?>
                    <tr data-id="<?= $row['id'] ?>">
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['cantidad'] ?></td>
                        <td><?= $row['precio'] ?></td>
                        <td><?= $row['tipo'] ?></td>
                        <td><?= $row['fecha_cosecha'] ?></td>
                        <td><?= $row['fecha_envio'] ?></td>
                        <td><?= $row['lote'] ?></td>
                        <td><?= $row['proveedor'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="cargarEdicion(<?= $row['id'] ?>)">Modificar</button>
                            <button class="btn btn-info btn-sm" onclick="generarCodigoBarras(<?= $row['id'] ?>)">Código de Barra</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <h3>Productos del Año 2025</h3>
            <table id="tablaProductos2025" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Tipo</th>
                        <th>Fecha Cosecha</th>
                        <th>Fecha Envío</th>
                        <th>Lote</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_2025->fetch_assoc()): ?>
                    <tr data-id="<?= $row['id'] ?>">
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['cantidad'] ?></td>
                        <td><?= $row['precio'] ?></td>
                        <td><?= $row['tipo'] ?></td>
                        <td><?= $row['fecha_cosecha'] ?></td>
                        <td><?= $row['fecha_envio'] ?></td>
                        <td><?= $row['lote'] ?></td>
                        <td><?= $row['proveedor'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="cargarEdicion(<?= $row['id'] ?>)">Modificar</button>
                            <button class="btn btn-info btn-sm" onclick="generarCodigoBarras(<?= $row['id'] ?>)">Código de Barra</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarProducto(<?= $row['id'] ?>)">Eliminar</button>

                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal del Código de Barras -->
    <div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeModalLabel">Código de Barra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="barcodeContainer">
                    <!-- La imagen y la secuencia se insertarán aquí dinámicamente -->
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Edición -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editCantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="editCantidad" name="cantidad">
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="editPrecio" name="precio">
                        </div>
                        <div class="mb-3">
                            <label for="editTipo" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="editTipo" name="tipo">
                        </div>

                        <div class="mb-3">
                            <label for="editFechaCosecha" class="form-label">Fecha de Cosecha</label>
                            <input type="date" class="form-control" id="editFechaCosecha" name="fecha_cosecha">
                        </div>
                        <div class="mb-3">
                            <label for="editFechaEnvio" class="form-label">Fecha de Envío</label>
                            <input type="date" class="form-control" id="editFechaEnvio" name="fecha_envio">
                        </div>

                        <div class="mb-3">
                            <label for="editLote" class="form-label">Lote</label>
                            <input type="text" class="form-control" id="editLote" name="lote">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="guardarEdicion()">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Agregar Producto -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label for="addCantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="addCantidad" name="cantidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPrecio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="addPrecio" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="addTipo" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="addTipo" name="tipo" required>
                        </div>

                        <div class="mb-3">
                            <label for="addFechaCosecha" class="form-label">Fecha de Cosecha</label>
                            <input type="date" class="form-control" id="addFechaCosecha" name="fecha_cosecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="addFechaEnvio" class="form-label">Fecha de Envío</label>
                            <input type="date" class="form-control" id="addFechaEnvio" name="fecha_envio" required>
                        </div>
                        <div class="mb-3">
                            <label for="addLote" class="form-label">Lote</label>
                            <input type="text" class="form-control" id="addLote" name="lote" required>
                        </div>

                        <div class="mb-3">
                            <label for="addProveedor" class="form-label">Proveedor</label>
                            <select class="form-control" id="addProveedor" name="proveedor_id" required>
                                <option value="">Seleccione un proveedor</option>
                                <?php while ($prov = $result_proveedores->fetch_assoc()): ?>
                                    <option value="<?= $prov['id'] ?>"><?= $prov['nombre'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="guardarNuevo()">Guardar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaProductos').DataTable({
                "pageLength": 25,
                "lengthMenu": [10, 25, 50, 100],
                "ordering": true,
                "searching": true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });



        function eliminarProducto(id) {
            if (!confirm("¿Estás seguro de que deseas eliminar este registro?")) {
                return;
            }

            // La URL debe incluir el ID como parte de la cadena de consulta
            fetch(`eliminar_producto.php?id=${id}`, {
                method: 'GET',  // Asegúrate de usar 'GET' y no incluir un body
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);  // Mensaje de éxito
                    location.reload();
                } else {
                    alert(data.message);  // Mensaje de error
                }
            })
            .catch(error => {
                console.error('Error al eliminar el producto:', error);
            });
        }




        function generarCodigoBarras(id) {
            let fila = document.querySelector(`tr[data-id='${id}']`);
            if (!fila) {
                console.error("No se encontró la fila para el ID:", id);
                return;
            }

            let celdas = fila.getElementsByTagName('td');
            if (celdas.length < 7) {
                console.error("No se encontraron suficientes celdas en la fila");
                return;
            }

            let lote = celdas[6].innerText.trim(); // 7ma columna (Lote)
            let fechaCosecha = celdas[4].innerText.trim(); // 5ta columna (Fecha Cosecha)

            // Eliminar guiones de la fecha
            let fechaFormateada = fechaCosecha.replace(/-/g, '');

            console.log("Generando código para ID:", id, "Lote:", lote, "Fecha Cosecha:", fechaFormateada);

            let timestamp = new Date().getTime();
            let url = `codigo_barra.php?id=${id}&lote=${lote}&fecha_cosecha=${fechaFormateada}&_=${timestamp}`;

            document.getElementById('barcodeContainer').innerHTML = `
                <img src="${url}" alt="Código de barras" class="img-fluid">
                <div id="codigoSecuencia" style="text-align: center; margin-top: 10px;">
                    ${lote}${id}${fechaFormateada}
                </div>
            `;

            setTimeout(() => {
                let barcodeModal = new bootstrap.Modal(document.getElementById('barcodeModal'));
                barcodeModal.show();
            }, 300);
        }




        function cargarEdicion(id) {
            // Verifica si se ha pasado un id
            if (!id) {
                alert('ID no válido');
                return;
            }

            // Imprimir en consola para asegurarse de que el ID es válido
            console.log("ID pasado:", id);

            fetch('obtener_producto.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        document.getElementById('editId').value = data.id;
                        document.getElementById('editCantidad').value = data.cantidad;
                        document.getElementById('editPrecio').value = data.precio;
                        document.getElementById('editTipo').value = data.tipo;
                        document.getElementById('editFechaCosecha').value = data.fecha_cosecha;
                        document.getElementById('editFechaEnvio').value = data.fecha_envio;
                        document.getElementById('editLote').value = data.lote;

                        new bootstrap.Modal(document.getElementById('editModal')).show();
                    } else {
                        alert('No se pudo cargar el producto: ' + (data.error || 'Error desconocido'));
                    }
                })
                .catch(error => console.error('Error:', error));
        }




        function guardarEdicion() {
            let formData = new FormData(document.getElementById('editForm'));

            fetch('editar_producto.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(response => {
                alert(response);
                location.reload();
            });
        }


        function guardarNuevo() {
            let formData = new FormData(document.getElementById('addForm'));

            fetch('agregar_producto.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(response => {
                alert(response);
                location.reload();
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Agregar el footer
        document.body.append(Components.createFooter());
    </script>
</body>
</html>
