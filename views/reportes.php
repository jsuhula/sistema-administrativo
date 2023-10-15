<?php 

session_start();
if ($_SESSION) {
  header('location: ../login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <header class="bg-dark text-white text-center">
        <span class="display-4">Generar Reportes</span>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                        <a id="regresar" class="nav-link" href="../index.php"><i class="fas fa-arrow-left"></i> Regresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" onclick="showSection('ventas')">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" onclick="showSection('cierres-caja')">Cierres de Caja</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-4">
        <!-- Sección de Ventas -->
        <section id="ventas" class="bg-white container rounded-4 shadow-lg p-4">
            <h2>Ventas</h2>

            <!-- Formulario para seleccionar el período de tiempo -->
            <form>
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <label for="periodo-seleccion-venta" class="col-form-label">Selecciona el Periodo: </label>
                        <select class="form-select" id="periodo-seleccion-venta" name="periodo-seleccion-venta">
                            <option value="hoy">Hoy</option>
                            <option value="ayer">Ayer</option>
                            <option value="mes-actual">Mes Actual</option>
                            <option value="mes-pasado">Mes Pasado</option>
                            <option value="personalizado">Personalizado</option>
                        </select>
                    </div>
                    <div class="col-sm-4" id="fecha-inicio-venta" style="display: none;">
                        <label for="fechaInicioVenta" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fechaInicioVenta">
                    </div>
                    <div class="col-sm-4" id="fecha-fin-venta" style="display: none;">
                        <label for="fechaFinVenta" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fechaFinVenta">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success" id="buscar-ventas">Buscar</button>
                        <button type="button" class="btn btn-secondary" id="exportar-ventas">Exportar</button>
                    </div>
                </div>

            </form>

            <h3>Resultados</h3>
            <div class="table-resposive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023-09-01</td>
                            <td>Producto A</td>
                            <td>5</td>
                            <td>$150.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-02</td>
                            <td>Producto B</td>
                            <td>3</td>
                            <td>$90.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-03</td>
                            <td>Producto A</td>
                            <td>2</td>
                            <td>$60.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-01</td>
                            <td>Producto A</td>
                            <td>5</td>
                            <td>$150.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-02</td>
                            <td>Producto B</td>
                            <td>3</td>
                            <td>$90.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-03</td>
                            <td>Producto A</td>
                            <td>2</td>
                            <td>$60.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-01</td>
                            <td>Producto A</td>
                            <td>5</td>
                            <td>$150.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-02</td>
                            <td>Producto B</td>
                            <td>3</td>
                            <td>$90.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-03</td>
                            <td>Producto A</td>
                            <td>2</td>
                            <td>$60.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="cierres-caja" class="bg-white container rounded-4 shadow-lg p-4" style="display: none;">
            <h2>Cierres de Caja</h2>

            <!-- Formulario para consultar cierres -->
            <form>
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <label for="periodo-seleccion-caja" class="col-form-label">Selecciona el Periodo:</label>
                        <select class="form-select" id="periodo-seleccion-caja" name="periodo-seleccion-caja">
                            <option value="<?php echo date("d-m-Y"); ?>">Hoy</option>
                            <option value="diario">Ayer</option>
                            <option value="mensual">Mes Actual</option>
                            <option value="mensual">Mes Pasado</option>
                            <option value="personalizado">Personalizado</option>
                        </select>
                    </div>
                    <div class="col-sm-4" id="fecha-inicio-caja" style="display: none;">
                        <label for="fechaInicioCaja" class="col-form-label">Fecha de Inicio:</label>
                        <input type="date" class="form-control" id="fechaInicioCaja">
                    </div>
                    <div class="col-sm-4" id="fecha-fin-caja" style="display: none;">
                        <label for="fechaFinCaja" class="col-form-label">Fecha de Fin:</label>
                        <input type="date" class="form-control" id="fechaFinCaja">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success" id="buscar-cierres">Buscar</button>
                        <button type="button" class="btn btn-secondary" id="exportar-cierres">Exportar</button>
                    </div>
                </div>
            </form>

            <h3>Resultados</h3>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo de Cierre</th>
                            <th>Total Ingresos</th>
                            <th>Total Egresos</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023-09-01</td>
                            <td>Diario</td>
                            <td>$1500.00</td>
                            <td>$500.00</td>
                            <td>$1000.00</td>
                        </tr>
                        <tr>
                            <td>2023-09-01</td>
                            <td>Mensual</td>
                            <td>$1800.00</td>
                            <td>$700.00</td>
                            <td>$1100.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function showSection(sectionId) {
            // Obtener todas las secciones
            var sections = document.querySelectorAll('section');

            // Ocultar todas las secciones
            sections.forEach(function(section) {
                section.style.display = 'none';
            });

            // Mostrar la sección seleccionada
            var selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
        }

        const fechaSeleccionVenta = document.getElementById('periodo-seleccion-venta');
        const fechaInicioVenta = document.getElementById('fecha-inicio-venta');
        const fechaFinVenta = document.getElementById('fecha-fin-venta');

        fechaSeleccionVenta.addEventListener('change', function() {
            const seleccion = fechaSeleccionVenta.value;

            fechaInicioVenta.style.display = 'none';
            fechaFinVenta.style.display = 'none';

            if (seleccion === 'personalizado') {
                fechaInicioVenta.style.display = 'block';
                fechaFinVenta.style.display = 'block';
            }
        });

        const regresarLink = document.getElementById('regresar');
        const fechaSeleccionCaja = document.getElementById('periodo-seleccion-caja');
        const fechaInicioCaja = document.getElementById('fecha-inicio-caja');
        const fechaFinCaja = document.getElementById('fecha-fin-caja');

        fechaSeleccionCaja.addEventListener('change', function() {
            const seleccion = fechaSeleccionCaja.value;

            fechaInicioCaja.style.display = 'none';
            fechaFinCaja.style.display = 'none';

            if (seleccion === 'personalizado') {
                fechaInicioCaja.style.display = 'block';
                fechaFinCaja.style.display = 'block';
            }
        });

        regresarLink.addEventListener('click', function (event) {
            event.preventDefault();

            window.location.href = '../index.php'; // 
        });
    </script>
</body>

</html>