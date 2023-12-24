<?php
date_default_timezone_set('America/Guatemala');
use dao\UsuarioAccessoDAO;

session_start();
if (!$_SESSION) {
    header('location: ../login.php');
}

main();

function main()
{
    require_once('../dao/UsuarioAccessoDAO.php');
    require_once('../includes/MySQLConnector.php');
    $usuario = new UsuarioAccessoDAO();
    $permisos = $usuario->validarRolUsuario($_SESSION['CodigoUsuario'])->fetch(PDO::FETCH_OBJ);
    if ($permisos->Existe != 0) {
        if ($permisos->GestionaNomina != 1) {
            header('location: ../login.php');
        }
    } else {
        header('location: ../login.php');
    }
}

$fechaOperacion = date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Nómina</title>
    <link rel="icon" href="../resources/food.svg" type="image/svg+xml">
    <link rel="stylesheet" href="../src/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>

<body style="background-color: #DAEAF1">
    <header class="text-white text-center" style="background-color: #379392">
        <span class="display-4">Gestión de Nómina</span>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #379392">
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
                        <a class="nav-link" href="#" data-section="salarios"><i class="fa-solid fa-wallet"></i>
                            Pago Salarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="bonificaciones"><i
                                class="fa-solid fa-wallet"></i> Pago Bonificacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="liquidacion"><i
                                class="fa-solid fa-file-contract"></i> Liquidacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="informes"><i
                                class="fa-solid fa-chart-simple"></i> Informes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="resumen"><i class="fa-solid fa-list"></i>
                            Resumen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-md">

        <!-- Cálculo de Salarios -->
        <section id="salarios" class="container content-section bg-white shadow-lg p-4">
            <h2>Cálculo de Salarios</h2>
            <form>
                <div class="row align-items-center justify-content-between">
                    <label for="fechaNominaSalario" class="form-label">Fecha Atención:</label>
                    <div class="col-md-3 p-2">
                        <input type="date" class="form-control" id="fechaNominaSalario">
                    </div>
                    <div class="col-md-3 p-2">
                        <button type="button" class="btn btn-sm btn-primary text-white"
                            onclick="calcularNominaSalario()">CALCULAR</button>
                    </div>
                </div>
            </form>
            <!-- Resultado del cálculo de salarios -->
            <h3 class="text-secondary pt-4">Resultados:</h3>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table id="tablaNominaSalario" class="table table-striped text-end">
                    <thead class="sticky-top">
                        <tr>
                            <th>Código Empleado</th>
                            <th>Salario</th>
                            <th>Comisiones</th>
                            <th>Horas Extras</th>
                            <th>Horas No Trabajadas</th>
                            <th>IGSS</th>
                            <th>IRTRA</th>
                            <th>Cuota Prestamo</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div id="existenciaReporteMesSeleccionado" class="row bg-danger p-2 rounded-4 bg-opacity-75 col-md-6 m-auto"
                hidden>
                <span class="text-center text-white">Ya existe un reporte de nómina en el periodo seleccionado</span>
            </div>
            <button id="confirmarOperacionNominaSalario" class="btn btn-sm btn-outline-danger bg-opacity-50 mt-3" disabled onclick="confirmarNominaSalario()">
                CONFIRMAR OPERACIÓN
            </button>
        </section>

        <!-- Cálculo de Bonificaciones -->
        <section id="bonificaciones" class="container content-section bg-white shadow-lg p-4">
            <h2>Cálculo de Bonificaciones</h2>
            <form>
                <div class="row align-items-center justify-content-between">
                    <label for="SelectTipoBonificacion" class="form-label">Tipo Bonificacion:</label>
                    <div class="col-sm-3 p-2">
                        <select class="form-select" id="SelectTipoBonificacion">
                            <option value="1">Bono 14</option>
                            <option value="2">Aguinaldo</option>
                        </select>
                    </div>
                    <div class="col-sm-3 p-2">
                    <input type="date" class="form-control" id="fechaPagoBonificacion">
                    </div>
                    <div class="col-sm-3 p-2">
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="calcularBonificacion()">CALCULAR</button>
                    </div>
                </div>
            </form>

            <!-- Resultado del cálculo de bonificaciones -->
            <h3 class="text-secondary pt-4">Resultado del Cálculo:</h3>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table id="tablaPagoBonificacion" class="table table-striped text-end">
                    <thead class="sticky-top">
                        <tr>
                            <th>Fecha Ultimo Pago</th>
                            <th>Empleado</th>
                            <th>Puesto</th>
                            <th>Bono</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div id="existenciaPagoBonoSeleccionado" class="row bg-danger p-2 rounded-4 bg-opacity-75 col-md-6 m-auto"
                hidden>
                <span class="text-center text-white">Ya existe un reporte de pago para la bonificación seleccionada</span>
            </div>
            <button id="confirmarOperacionPagoBonificacion" class="btn btn-sm btn-outline-danger bg-opacity-50 mt-3" disabled onclick="confirmarPagoBonificacion()">
                CONFIRMAR OPERACIÓN
            </button>
        </section>

        <!-- Calculo de liquidacion -->
        <section id="liquidacion" class="container content-section bg-white shadow-lg p-4">
            <h2>Cálculo de Liquidación</h2>

            <form>
                <div class="row align-items-center justify-content-between">
                    <label for="empleado_liquidacion" class="form-label">Nombre de Empleado:</label>
                    <div class="col-md-6 p-2">
                        <select class="form-select" id="empleado_liquidacion">
                            <option value="1">Empleado 1</option>
                            <option value="2">Empleado 2</option>
                        </select>
                    </div>
                    <div class="col-md-3 p-2">
                        <button type="submit" class="btn btn-sm btn-primary">CALCULAR</button>
                    </div>
                </div>
            </form>

            <h3 class="caption-top mt-4 text-secondary">General</h3>
            <div class="table-resposive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped" id="tabla-general">
                    <thead>
                        <tr>
                            <th>Razon</th>
                            <th>Articulo C.T</th>
                            <th>De Fecha</th>
                            <th>A Fecha</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Indemnización</td>
                            <td>Articulo 82</td>
                            <td>01/01/2010</td>
                            <td>15/08/2023</td>
                            <td>Q.10,500.00</td>
                        </tr>
                        <tr>
                            <td>Aguinaldo</td>
                            <td>Articulo 130</td>
                            <td>01/01/2010</td>
                            <td>15/08/2023</td>
                            <td>Q.1,500.00</td>
                        </tr>
                        <tr>
                            <td>Bono 14</td>
                            <td>Articulo 82</td>
                            <td>01/01/2010</td>
                            <td>15/08/2023</td>
                            <td>Q.2,500.00</td>
                        </tr>
                        <tr>
                            <td>Vacaciones</td>
                            <td>Articulo 8</td>
                            <td>01/01/2010</td>
                            <td>15/08/2023</td>
                            <td>Q.1,500.00</td>
                        </tr>
                        <tr>
                            <td>Horas Extras Pendientes</td>
                            <td>Articulo 11</td>
                            <td>01/01/2010</td>
                            <td>15/08/2023</td>
                            <td>Q.500.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <table class="table table-success">
                <tfoot>
                    <tr>
                        <td class="fw-bold">TOTAL A LIQUIDAR: Q.<span>22,000.00</span></td>
                    </tr>
                </tfoot>
            </table>
            <button class="btn btn-sm btn-outline-primary" id="generar-liquidacion">Generar Liquidación</button>
        </section>

        <!-- Generación de Informes -->
        <section id="informes" class="container content-section bg-white shadow-lg p-4">
            <h2>Generación de Informes</h2>
            <span id="AlertaExistenciaDatosParaInforme" class="text-center text-danger" hidden>No existen datos para el informe</span>
            <br />
            <!-- Sección de Pago de Nómina -->
            <hr class="my-4">
            <div class="row mb-3 align-items-end">
                <h3 class="text-secondary pt-2">Pago Nómina</h3>
                <div class="col-md-6 mb-2">
                    <label for="tipo_informe_nomina" class="form-label">Tipo:</label>
                    <select class="form-select" id="tipo_informe_nomina">
                        <option value="1">Mensual</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label for="fechaInformeNominaSalario" class="form-label">Fecha:</label>
                    <input type="date" class="form-control" id="fechaInformeNominaSalario">
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-sm btn-primary text-white" onclick="validarExisteReporteNomina()">Generar
                        Informe</button>
                </div>
            </div>

            <!-- Sección de Pago de Bonificaciones -->
            <hr class="my-4">
            <div class="row mb-3 align-items-end">
                <h3 class="text-secondary pt-2">Pagos Prestaciones</h3>
                <div class="col-md-6 mb-2">
                    <label for="SelectTipoInformeBonificacion" class="form-label">Tipo:</label>
                    <select class="form-select" id="SelectTipoInformeBonificacion">
                        <option value="1">Pago Bono 14</option>
                        <option value="2">Pago Aguinaldo</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label for="fechaInformePagoBonificacion" class="form-label">Fecha:</label>
                    <input type="date" class="form-control" id="fechaInformePagoBonificacion">
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-sm btn-primary text-white" onclick="exportarPagoBonificacion()">Generar
                        Informe</button>
                </div>
            </div>

            <!-- Sección de Liquidaciones -->
            <hr class="my-4">
            <div class="row mb-3 align-items-end">
                <h3 class="text-secondary pt-2">Liquidaciones</h3>
                <div class="col-md-3 mb-2">
                    <label for="fecha_despido" class="form-label">Fecha Despido (Mes):</label>
                    <input type="month" class="form-control" id="fecha_despido">
                </div>
                <div class="col-md-3 mb-2">
                    <label for="tipo_informe_liquidacion" class="form-label">Empleado:</label>
                    <select class="form-select" id="tipo_informe_liquidacion">
                        <option value="1">Empleado 1</option>
                        <option value="2">Empleado 2</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-sm btn-primary text-white">Generar Informe</button>
                </div>
            </div>
        </section>

        <!-- Seccion de Resumen -->
        <section id="resumen" class="container content-section bg-white shadow-lg p-4">
            <h2>Resumen por Conceptos</h2>
            <table class="table table-striped">
                <thead class="sticky-top">
                    <tr>
                        <th>Concepto</th>
                        <th>Horas</th>
                        <th>Empleados</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Horas Trabajadas</td>
                        <td>120</td>
                        <td>10</td>
                        <td>Q.50,500.00</td>
                    </tr>
                    <tr>
                        <td>Horas Extras</td>
                        <td>20</td>
                        <td>10</td>
                        <td>Q.1,500.00</td>
                    </tr>
                    <tr>
                        <td>Comisiones</td>
                        <td>0</td>
                        <td>5</td>
                        <td>Q.25,500.00</td>
                    </tr>
                    <tr>
                        <td>IGSS</td>
                        <td>0</td>
                        <td>10</td>
                        <td>Q.1,500.00</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/funciones-nomina.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');
            const contentSections = document.querySelectorAll('.content-section');
            const regresarLink = document.getElementById('regresar');

            // Función para ocultar todas las secciones excepto la lista de usuarios
            function hideAllSectionsExcept() {
                contentSections.forEach(section => {
                    if (section.id === 'salarios') {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }

            hideAllSectionsExcept();

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
                event.preventDefault();

                window.location.href = '../index.php';
            });
        });
    </script>
</body>

</html>