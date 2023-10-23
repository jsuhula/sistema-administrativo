<?php
// Iniciar la sesión (debes tener una sesión activa en tu aplicación)
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <header class="bg-dark text-white text-center">
        <span class="display-4">Gestión de Préstamos</span>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                        <a id="regresar" class="nav-link" href="/index.php"><i class="fas fa-arrow-left"></i>
                            Regresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="ver-prestamos" href="#"><i
                                class="fas fa-hand-holding-usd"></i>Préstamos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <!-- Ver Préstamos -->
        <section id="ver-prestamos" class="content-section container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4">
            <h2>Préstamos</h2>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-auto col-md-6">
                    <div class="input-group mb-3">
                        <input id="empleadoBusqueda" type="text" class="form-control w-50"
                            placeholder="Nombre de Empleado" aria-label="Buscar" maxlength="45">
                        <button class="btn btn-outline-secondary" type="button" id="btnBuscarEmpleado"
                            onclick="buscarPrestamo()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table id="tablaPrestamos" class="table table-striped">
                    <thead class="sticky-top">
                        <tr class="text-center">
                            <th>Código</th>
                            <th>Fecha</th>
                            <th>Empleado</th>
                            <th>Cuotas</th>
                            <th>Cuotas Pendientes</th>
                            <th>Monto</th>
                            <th>Saldo Pendiente</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div>
            <hr>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoPrestamoModal"
                onclick="btnNuevoPrestamo()">
                Nuevo Préstamo
            </button>
            <button type="button" class="btn btn btn-outline-secondary" data-bs-toggle="modal"
                data-bs-target="#realizarAbonosModal" onclick="btnNuevoAbono()">
                Registrar Abono
            </button>
        </section>

        <!-- Modal de Nuevo Prestamo -->
        <div class="modal fade" id="nuevoPrestamoModal" tabindex="-1" aria-labelledby="modalRol">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModalPrestamo">Prestamo: </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertaExitoPrestamo" class="row m-2" hidden>
                            <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                                correctamente</span>
                        </div>
                        <div id="alertaErrorPrestamo" class="row m-2" hidden>
                            <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Ocurrio un error,
                                comuniquese con soporte</span>
                        </div>
                        <div id="alertaDuplicadoPrestamo" class="row m-2" hidden>
                            <span class="bg-warning bg-opacity-75 p-2 text-center text-white rounded-4">Ya existe un
                                Departamento con este nombre</span>
                        </div>
                        <div id="alertaNoAfectacionPrestamo" class="row m-2" hidden>
                            <span class="bg-info bg-opacity-75 p-2 text-center text-white rounded-4">No se realizaron
                                Cambios</span>
                        </div>
                        <div id="alertaCompletarCamposPrestamo" class="row m-2" hidden>
                            <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Llene todos los
                                campos</span>
                        </div>
                        <div id="alertaEmpleadoExistePrestamo" class="row m-2" hidden>
                            <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">El empleado
                                cuenta con un prestamo pendiente</span>
                        </div>
                        <form id="formPrestamo">
                            <div class="mb-3">
                                <label for="fechaPrestamo" class="form-label">Fecha: </label>
                                <input type="date" class="form-control" id="fechaPrestamo" name="fechaPrestamo"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="montoPrestamo" class="form-label">Monto del Prestamo: </label>
                                <select id="montoPrestamo" class="form-select">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1500">Q1500.00</option>
                                    <option value="3000">Q3000.00</option>
                                    <option value="6000">Q6000.00</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="selectEmpleadoPrestamo" class="form-label">Empleado: </label>
                                <select id="selectEmpleadoPrestamo" name="selectEmpleadoPrestamo" class="form-select">
                                    <option value="" selected disabled>Seleccione un empleado</option>
                                    <option value="1">Jefe</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="selectCuotasPrestamo" class="form-label">Cuotas: </label>
                                <select id="selectCuotasPrestamo" class="form-select" name="selectCuotasPrestamo">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1">1</option>
                                    <option value="3">3</option>
                                    <option value="6">6</option>
                                </select>
                            </div>
                            <button id="btnGuardarPrestamo" type="button" class="btn btn-success"
                                onclick="guardarPrestamo()">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Realizar Abonos -->
        <div class="modal fade" id="realizarAbonosModal" tabindex="-1" aria-labelledby="realizarAbonosModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="realizarAbonosModalLabel">Realizar Abono</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertaValidacion" class="row m-2" hidden>
                            <span class="bg-warning bg-opacity-75 p-2 text-center text-white rounded-4">Para validar
                                indique el codigo de prestamo</span>
                        </div>
                        <div id="alertaExitoAbono" class="row m-2" hidden>
                            <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                                correctamente</span>
                        </div>
                        <div id="alertaErrorAbono" class="row m-2" hidden>
                            <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Ocurrio un error,
                                comuniquese con soporte</span>
                        </div>
                        <div id="alertaDuplicadoAbono" class="row m-2" hidden>
                        </div>
                        <div id="alertaNoAfectacionAbono" class="row m-2" hidden>
                        </div>
                        <div id="alertaCompletarCamposAbono" class="row m-2" hidden>
                            <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Llene todos los
                                campos</span>
                        </div>
                        <div id="alertaEmpleadoExisteAbono" class="row m-2" hidden></div>
                        <form id="formAbono">
                            <div class="mb-3">
                                <label for="fechaAbono" class="form-label">Fecha:</label>
                                <input type="date" class="form-control" id="fechaAbono" name="fechaAbono" required>
                            </div>
                            <div class="mb-3">
                                <label for="codigoPrestamo" class="form-label">Código del Préstamo:</label>
                                <input type="text" class="form-control" id="codigoPrestamo" name="codigoPrestamo"
                                    placeholder="01234">
                            </div>
                            <div class="mb-3">
                                <label for="montoAbono" class="form-label">Cuotas a abonar:</label>
                                <select id="selectCuotasAbonarPrestamo" name="selectCuotasAbonarPrestamo" class="form-select">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <table class="text-center table table-sm table-striped-columns table-bordered">
                                <tr>
                                    <td colspan="6"><span><b>Codigo Prestamo:</b></span></td>
                                    <td id="codigoPrestamoValidacion" colspan="6" class="text-right"></td>
                                    <td colspan="6"><span><b>Codigo Empleado:</b></span></td>
                                    <td id="empleadoPrestamoValidacion" colspan="6" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><span><b>Monto:<b></span></td>
                                    <td id="montoPrestamoValidacion" colspan="6" class="text-right"></td>
                                    <td colspan="6"><span><b>Saldo Pendiente:</b></span></td>
                                    <td id="saldoPendienteValidacion" colspan="6" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td colspan="12"><b>Monto Cuota: Q.</b></td>
                                    <td id="montoCuotaValidacion" colspan="12"
                                        class="text-right text-white bg-dark bg-opacity-50"></td>
                                </tr>
                            </table>
                            <button id="btnGuardarAbono" type="button" class="btn btn-success" name="btnRealizarAbono"
                                onclick="guardarAbono()">Realizado</button>
                            <button id="btnValidarPrestamo" type="button" class="btn btn-outline-secondary"
                                name="btnValidar" onclick="cargarPrestamoValidacion()">Validar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/funciones-prestamo.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');
            const contentSections = document.querySelectorAll('.content-section');
            const regresarLink = document.getElementById('regresar');

            // Función para ocultar todas las secciones excepto la lista de usuarios
            function hideAllSectionsExceptListaUsuarios() {
                contentSections.forEach(section => {
                    if (section.id === 'ver-prestamos') {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }

            // Al cargar la página, muestra solo la lista de usuarios
            hideAllSectionsExceptListaUsuarios();

            navLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    // Oculta todas las secciones
                    contentSections.forEach(section => {
                        section.style.display = 'none';
                    });

                    // Muestra la sección correspondiente a la opción seleccionada
                    const targetSectionId = this.getAttribute('data-section');
                    const targetSection = document.getElementById(targetSectionId);
                    if (targetSection) {
                        targetSection.style.display = 'block';
                    }
                });
            });

            regresarLink.addEventListener('click', function (event) {
                window.location.href = '../index.php';
            });
        });
    </script>
</body>

</html>