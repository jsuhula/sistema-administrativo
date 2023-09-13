<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Nómina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <header class="bg-dark text-white text-center">
        <span class="display-4">Gestión de Nómina</span>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li>
                            <a id="regresar" class="nav-link" href="/index.php"><i class="fas fa-arrow-left"></i>
                                Regresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#salarios" data-section="resumen">Salarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#comisiones" data-section="comisiones">Comisiones</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#liquidacion" data-section="liquidacion">Liquidacion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#informes" data-section="informes">Informes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#resumen" data-section="resumen">Resumen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">

        <!-- Cálculo de Salarios -->
        <section id="salarios" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4">
            <h2>Cálculo de Salarios</h2>
            <form>
                <div class="mb-3">
                    <label for="mes" class="form-label">Selecciona el Mes:</label>
                    <select class="form-select" id="mes">
                        <option value="enero">Enero</option>
                        <option value="febrero">Febrero</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Calcular Salarios</button>
            </form>
            <!-- Resultado del cálculo de salarios -->
            <h3>Resultado del Cálculo</h3>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Empleado</th>
                            <th>Salario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Empleado 1</td>
                            <td>Q.2500.00</td>
                            <td>Q.2500.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 2</td>
                            <td>Q.3000.00</td>
                            <td>Q.3000.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 1</td>
                            <td>Q.2500.00</td>
                            <td>Q.2500.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 2</td>
                            <td>Q.3000.00</td>
                            <td>Q.3000.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 1</td>
                            <td>Q.2500.00</td>
                            <td>Q.2500.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 2</td>
                            <td>Q.3000.00</td>
                            <td>Q.3000.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 1</td>
                            <td>Q.2500.00</td>
                            <td>Q.2500.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 2</td>
                            <td>Q.3000.00</td>
                            <td>Q.3000.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 1</td>
                            <td>Q.2500.00</td>
                            <td>Q.2500.00</td>
                        </tr>
                        <tr>
                            <td>Empleado 2</td>
                            <td>Q.3000.00</td>
                            <td>Q.3000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>

        <!-- Seccion de Comisiones -->
        <section id="comisiones" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4" hidden>
            <h2>Comisiones de Meseros y Chefs</h2>

            <div class="mb-3">
                <label for="tipoComision" class="form-label">Selecciona el tipo de comisión:</label>
                <select class="form-select" id="tipoComision" onchange="mostrarComisiones()">
                    <option value="mesero">Mesero</option>
                    <option value="chef">Chef</option>
                </select>
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

            <div class="mb-4">
                <label for="empleados-inactivos" class="form-label">Selecciona un empleado:</label>
                <select class="form-select" id="empleados-inactivos">
                    <option value="1">Empleado 1</option>
                    <option value="2">Empleado 2</option>
                    <option value="3">Empleado 3</option>
                </select>
            </div>
            <div>
                <caption class="caption-top">General</caption>
                <table class="table table-striped mt-4" id="tabla-liquidacion">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Fecha de Ingreso</th>
                            <th>Fecha de Retiro</th>
                            <th>Sueldo Mensual</th>
                            <th>Indemnización</th>
                            <th>Total de Liquidación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Empleado 1</td>
                            <td>01/01/2010</td>
                            <td>15/08/2023</td>
                            <td>Q.3000.00</td>
                            <td>Q.2500.00</td>
                            <td>Q.5500.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <caption class="caption-top">Vacaciones</caption>
                <table class="table table-striped mt-4" id="tabla-liquidacion">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Fecha de Ingreso</th>
                            <th>Fecha de Retiro</th>
                            <th>Total Dias</th>
                            <th>Dias pendientes</th>
                            <th>Total de Liquidación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Empleado 1</td>
                            <td>01/01/2010</td>
                            <td>15/08/2023</td>
                            <td>25</td>
                            <td>10</td>
                            <td>Q.2500.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-success" id="generar-liquidacion">Generar Liquidación</button>
        </section>

        <!-- Generación de Informe de Nómina -->
        <section id="informes" class="container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4" hidden>
            <h2>Generación de Informe de Nómina</h2>
            <form>
                <div class="mb-3">
                    <label for="mesInforme" class="form-label">Selecciona el Mes:</label>
                    <select class="form-select" id="mesInforme">
                        <option value="enero">Enero</option>
                        <option value="febrero">Febrero</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Generar Informe</button>
            </form>
            <h3>Descargar Informe de Nómina</h3>
            <a href="#" class="btn bg-danger bg-opacity-75"><i class="fas fa-download"></i> Descargar Informe</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;
            const salarios = document.getElementById('salarios');
            const informes = document.getElementById('informes');
            const liquidaciones = document.getElementById('liquidacion');
            const resumen = document.getElementById('resumen');
            const comisiones = document.getElementById('comisiones');
            const regresarLink = document.getElementById('regresar');

            const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    if (targetId === 'salarios') {
                        salarios.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        liquidaciones.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                    } else if (targetId === 'informes') {
                        informes.removeAttribute('hidden');

                        liquidaciones.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');

                    } else if (targetId === 'liquidacion') {
                        liquidaciones.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');

                    } else if (targetId === 'resumen') {
                        resumen.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        liquidaciones.setAttribute('hidden', 'true');
                        comisiones.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');

                    } else if (targetId === 'comisiones') {
                        comisiones.removeAttribute('hidden');

                        informes.setAttribute('hidden', 'true');
                        liquidaciones.setAttribute('hidden', 'true');
                        resumen.setAttribute('hidden', 'true');
                        salarios.setAttribute('hidden', 'true');

                    }
                });
            });

            regresarLink.addEventListener('click', function(event) {
                event.preventDefault();

                window.location.href = '../index.php';
            });
        });
    </script>
</body>

</html>