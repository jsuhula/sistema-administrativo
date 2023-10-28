<?php 
date_default_timezone_set('America/Guatemala');
use dao\UsuarioAccessoDAO;

session_start();
if (!$_SESSION) {
  header('location: ../login.php');
}

main();

function main(){
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Nómina</title>
    <link rel="icon" href="../resources/food.svg" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>

<body style="background-color: #CBC6CC">
    <header class="text-white text-center" style="background-color: #41292C">
        <span class="display-4">Gestión de Nómina</span>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #41292C">
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
                        <a class="nav-link" href="#salarios" data-section="salarios"><i class="fa-solid fa-wallet"></i> Pago Salarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#bonificaciones" data-section="bonificaciones"><i class="fa-solid fa-wallet"></i> Pago Bonificacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#liquidacion" data-section="liquidacion"><i class="fa-solid fa-file-contract"></i> Liquidacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#informes" data-section="informes"><i class="fa-solid fa-chart-simple"></i> Informes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#comisiones" data-section="comisiones"><i class="fa-solid fa-dollar-sign"></i> Comisiones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#resumen" data-section="resumen"><i class="fa-solid fa-list"></i> Resumen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">

        <!-- Cálculo de Salarios -->
        <section id="salarios" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4">
            <h2>Cálculo de Salarios</h2>
            <form>
                <div class="row align-items-center justify-content-between">
                    <label for="fechaNominaSalario" class="form-label">Fecha Atención:</label>
                    <div class="col-md-3 p-2">
                        <input type="date" class="form-control" id="fechaNominaSalario">
                    </div>
                    <div class="col-md-3 p-2">
                        <button type="button" class="btn btn-secondary" onclick="calcularNominaSalario()">Calcular</button>
                    </div>
                </div>
            </form>
            <!-- Resultado del cálculo de salarios -->
            <h3 class="text-secondary pt-4">Resultado del Cálculo:</h3>
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
            <div id="existenciaReporteMesSeleccionado" class="row bg-danger p-2 rounded-4 bg-opacity-75 col-md-6 m-auto" hidden>
                <span class="text-center text-white">Ya existe un reporte de nomina del mes seleccionado</span>
            </div>
            <button id="confirmarOperacionNominaSalario" class="btn btn-danger bg-opacity-50 mt-3" data-bs-toggle="modal"
                data-bs-target="#editarUsuarioModal" disabled onclick="confirmarNominaSalario()">
                CONFIRMAR OPERACION
            </button>
        </section>

        <!-- Cálculo de Bonificaciones -->
        <section id="bonificaciones" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4" hidden>
            <h2>Cálculo de Bonificaciones</h2>
            <form>
                <div class="row align-items-center justify-content-between">
                    <label for="tipo_bonificacion" class="form-label">Tipo Bonificacion:</label>
                    <div class="col-md-3 p-2">
                        <select class="form-select" id="SelectTipoBonificacion">
                            <option value="1">Bono 14</option>
                            <option value="2">Aguinaldo</option>
                        </select>
                    </div>
                    <div class="col-md-3 p-2">
                        <button type="submit" class="btn btn-secondary" onclick="calcularNominaBonificacion()">Calcular</button>
                    </div>
                </div>
            </form>

            <!-- Resultado del cálculo de bonificaciones -->
            <h3 class="text-secondary pt-4">Resultado del Cálculo:</h3>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table id="tablaNominaBonificacion" class="table table-striped text-end">
                    <thead class="sticky-top">
                        <tr>
                            <th>Código Empleado</th>
                            <th>Empleado</th>
                            <th>Bonificacion</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-danger bg-opacity-50 mt-3" data-bs-toggle="modal"
                data-bs-target="#editarUsuarioModal" disabled>
                CONFIRMAR OPERACION
            </button>
        </section>

        <!-- Seccion de Comisiones -->
        <section id="comisiones" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4" hidden>
            <h2>Comisiones de Meseros y Chefs</h2>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipoNomina" class="form-label">Seleccione:</label>
                    <select class="form-select" id="tipoNomina">
                        <option value="1">Chef/Cocinero (a)</option>
                        <option value="2">Mesero (a)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="mesInforme" class="form-label">Selecciona el Mes:</label>
                    <input type="month" class="form-control" id="mesInforme">
                </div>
            </div>

            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped" id="tablaComisiones">
                    <thead class="sticky-top">
                        <tr>
                            <th>Nombre</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,100.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,120.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,100.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,120.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,100.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,120.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,100.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,120.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,100.00</td>
                        </tr>
                        <tr>
                            <td>Mesero/Chef</td>
                            <td>Q.1,120.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>

        <!-- Calculo de liquidacion -->
        <section id="liquidacion" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4" hidden>
            <h2>Cálculo de Liquidación</h2>

            <form>
                <div class="row align-items-center justify-content-between">
                    <label for="empleado_liquidacion" class="form-label">Nombre de Empleado:</label>
                    <div class="col-md-6">
                        <select class="form-select" id="empleado_liquidacion">
                            <option value="1">Empleado 1</option>
                            <option value="2">Empleado 2</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-secondary">Calcular</button>
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
            <button class="btn btn-success" id="generar-liquidacion">Generar Liquidación</button>
        </section>

        <!-- Generación de Informes -->
        <section id="informes" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4" hidden>
            <h2>Generación de Informes</h2>

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
                    <label for="fecha_informe_nomina" class="form-label">Fecha:</label>
                    <input type="month" class="form-control" id="fecha_informe_nomina">
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-success">Generar Informe</button>
                </div>
            </div>

            <!-- Sección de Pago de Bonificaciones -->
            <hr class="my-4">
            <div class="row mb-3 align-items-end">
                <h3 class="text-secondary pt-2">Pago Bonificaciones</h3>
                <div class="col-md-6 mb-2">
                    <label for="tipo_informe_bonificacion" class="form-label">Tipo:</label>
                    <select class="form-select" id="tipo_informe_bonificacion">
                        <option value="1">Pago Bono 14</option>
                        <option value="2">Pago Aguinaldo</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label for="fecha_informe_bonificacion" class="form-label">Fecha:</label>
                    <input type="month" class="form-control" id="fecha_informe_bonificacion">
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-success">Generar Informe</button>
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
                    <button type="submit" class="btn btn-success">Generar Informe</button>
                </div>
            </div>
        </section>

        <!-- Seccion de Resumen -->
        <section id="resumen" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4" hidden>
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
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;
            const salarios = document.getElementById('salarios');
            const bonificaciones = document.getElementById('bonificaciones');
            const informes = document.getElementById('informes');
            const liquidaciones = document.getElementById('liquidacion');
            const resumen = document.getElementById('resumen');
            const comisiones = document.getElementById('comisiones');
            const regresarLink = document.getElementById('regresar');

            const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    if (targetId === 'salarios') {
                        salarios.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        liquidaciones.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        bonificaciones.setAttribute('hidden', true);

                    } else if (targetId === 'bonificaciones') {
                        bonificaciones.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        liquidaciones.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');

                    } else if (targetId === 'informes') {
                        informes.removeAttribute('hidden');

                        liquidaciones.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');
                        bonificaciones.setAttribute('hidden', true);

                    } else if (targetId === 'liquidacion') {
                        liquidaciones.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');
                        bonificaciones.setAttribute('hidden', true);

                    } else if (targetId === 'resumen') {
                        resumen.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        liquidaciones.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');
                        bonificaciones.setAttribute('hidden', true);

                    } else if (targetId === 'comisiones') {
                        comisiones.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        liquidaciones.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');
                        bonificaciones.setAttribute('hidden', true);

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