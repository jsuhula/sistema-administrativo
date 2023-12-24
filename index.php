<?php
require_once("config/autoload.php");
date_default_timezone_set('America/Guatemala');

session_start();
if (!$_SESSION) {
    header('location: login.php');
}

$fecha = date("Y-m-d H:i:s");
$usuario = new dao\UsuarioAccessoDAO();
$usuarioAsistencia = new dao\MarcajeDAO();
$usuarioSesion = $usuario->obtenerDatosDeSesion($_SESSION['CodigoUsuario'])->fetch(PDO::FETCH_OBJ);

if (isset($_POST['asistenciaEntrada'])) {
    $usuarioAsistencia->asistenciaEntrada($_SESSION['CodigoUsuario'], strval($fecha));
} else if (isset($_POST['asistenciaSalida'])) {
    $usuarioAsistencia->asistenciaSalida($_SESSION['CodigoUsuario'], strval($fecha));
}

$asistencia = $usuarioAsistencia->validarAsistencia($_SESSION['CodigoUsuario'], strval(date("Y-m-d")))->fetch(PDO::FETCH_OBJ);
$permisos = $usuario->validarRolUsuario($_SESSION['CodigoUsuario'])->fetch(PDO::FETCH_OBJ);
$nombreUsuarioActual = empty($usuarioSesion->NombreUsuarioSesion) ? $usuarioSesion->UsuarioEmail : $usuarioSesion->NombreUsuarioSesion;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="icon" href="resources/food.svg" type="image/svg+xml">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="src/main.css">
</head>

<body style="background-color: #DAEAF1">

    <header class="text-white text-center" style="background-color: #379392">
        <span class="display-4">Administración Restaurante</span>
    </header>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #379392">
        <div class="container">
            <button class="navbar-toggler" type="button" title="" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link"><i class="fas fa-user"></i>
                            <?php echo $nombreUsuarioActual; ?>
                        </span>
                    </li>
                    <?php if ($permisos->Existe != 0) {
                        if ($permisos->GestionaNomina != 0) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="views/administracion.nomina.php"><i class="fa-regular fa-folder-open"></i>
                                    Nómina</a>
                            </li>
                        <?php }
                        if ($permisos->GestionaPrestamos != 0) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="views/administracion.prestamos.php"><i class="fa-solid fa-wallet"></i>
                                    Préstamos</a>
                            </li>
                        <?php }
                        if ($permisos->GestionaEmpleados != 0) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="views/administracion.recursos-humanos.php"><i class="fa-solid fa-users"></i>
                                    RRHH</a>
                            </li>
                        <?php }
                        if ($permisos->GestionaMenu != 0) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="views/administracion.menu.php"><i class="fa-solid fa-drumstick-bite"></i>
                                    Menú</a>
                            </li>
                        <?php }
                        if ($permisos->GestionaReportes != 0) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="views/administracion.reportes.php"><i class="fa-solid fa-chart-simple"></i>
                                    Reportes</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item text-white">
                            <a class="nav-link" href="views/cliente.menu.php" target="_blank"><i class="fa-regular fa-eye"></i> Ver
                                Menú</a>
                        </li>
                        <?php if ($asistencia->ExisteEmpleado != 0) { ?>
                            <li class="nav-item text-white">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#marcajeAsistenciaModal"><i
                                        class="fa-solid fa-calendar-days"></i> Asistencia</a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
            <div class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="cerrarSesion()">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <div class="container-md shadow-lg p-md-5 bg-light">
        <div class="row mt-4">
            <div class="col-md-6 p-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title">Comparativa de Ventas</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Periodo</th>
                                    <th>Total de Ventas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Este Mes</td>
                                    <td>Q.1200</td>
                                </tr>
                                <tr>
                                    <td>Mes Pasado</td>
                                    <td>Q.1400</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-2">
                <div class="card h-100">
                    <div class="card-body lh-sm">
                        <h2 class="card-title">Platillos Más Vendidos</h2>
                        <p>Historicamente:</p>
                        <p><strong>Pato al Horno</strong></p>
                        <p>Mes Actual:</p>
                        <p><strong>Hamburguesa Monster</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Entrada -->
    <div class="modal fade" id="marcajeAsistenciaModal" tabindex="-1" aria-labelledby="marcajeAsistenciaModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="entradaModalLabel">Marcaje de Asistencia</h5>
                    <button type="button" class="btn-close" title="" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formMarcaje" method="POST">
                        <?php if ($asistencia->ExisteEntrada == 0) { ?>
                            <div class="mb-3">
                                <label for="asistenciaEntrada" class="form-label">Fecha y hora:</label>
                                <input id="asistenciaEntrada" type="datetime" class="form-control" name="asistenciaEntrada"
                                    readonly required value="<?php echo date("d-m-Y H:i:s"); ?>">
                            </div>
                            <button type="submit" title="" class="btn btn-primary text-white">Registrar
                                Entrada</button>
                        <?php } else if ($asistencia->ExisteSalida == 0) { ?>
                                <div class="mb-3">
                                    <label for="asistenciaSalida" class="form-label">Fecha y hora:</label>
                                    <input id="asistenciaSalida" type="datetime" class="form-control" name="asistenciaSalida"
                                        readonly required value="<?php echo date("d-m-Y H:i:s"); ?>">
                                </div>
                                <button type="submit" class="btn btn-danger" title="">Registrar Salida</button>
                        <?php } else {
                            ?>
                                <div class="bg-warning text-center rounded-4 p-2 m-2">
                                    <span class="text-white">Ya ha realizado sus respectivos marcajes de asistencia</span>
                                </div>
                            <?php
                        } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="js/funciones-index.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('.navbar');
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;

            window.addEventListener('scroll', function () {
                if (window.scrollY > headerHeight) {
                    navbar.classList.add('fixed-top');
                } else {
                    navbar.classList.remove('fixed-top');
                }
            });
        });
    </script>
</body>

</html>