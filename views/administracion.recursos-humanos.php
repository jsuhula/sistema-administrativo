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
        if ($permisos->GestionaEmpleados != 1) {
            header('location: ../login.php');
        }
    } else {
        header('location: ../login.php');
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Empleados</title>
    <link rel="icon" href="../resources/food.svg" type="image/svg+xml">
    <link rel="stylesheet" href="../src/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body style="background-color: #DAEAF1">
    <header class="text-white text-center" style="background-color: #379392">
        <span class="display-4">Recursos Humanos</span>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #379392">
        <div class="container">
            <button class="navbar-toggler" type="button" title="" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                        <a id="regresar" class="nav-link" href="../index.php"><i class="fas fa-arrow-left"></i>
                            Regresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="empleados"><i class="fa-solid fa-users-gear"></i>
                            Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="lista-usuarios"><i
                                class="fa-solid fa-user-group"></i> Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="departamentos"><i class="fa-solid fa-building"></i>
                            Departamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="roles"><i class="fa-solid fa-sitemap"></i> Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="comisiones"><i class="fa-solid fa-dollar-sign"></i>
                            Comisiones</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-md">

        <!-- Seccion de Empleados -->
        <section id="empleados" class="content-section bg-white shadow-lg p-4">
            <h2>Empleados</h2>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-auto col-md-6">
                    <div class="input-group mb-3">
                        <input id="empleadoBusqueda" type="text" class="form-control w-50" placeholder="Nombre"
                            aria-label="Buscar" maxlength="45">
                        <select class="form-select" title="Estado" id="estadoBusqueda" name="estadoBusqueda">
                            <option value="1" selected>Estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        <button class="btn btn-outline-secondary" title="" type="button" id="btnBuscarEmpleado"
                            onclick="buscarEmpleado()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

            </div>

            <div class="table-responsive" style="max-height: 40em; overflow-y: auto;">
                <table id="tablaEmpleados" class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Departamento</th>
                            <th>Salario Mensual</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <button class="btn btn-sm btn-primary mt-3" title="" data-bs-toggle="modal" data-bs-target="#empleadoModal"
                onclick="btnNuevoEmpleado()">
                NUEVO
            </button>
        </section>

        <!-- Seccion de Usuarios -->
        <section id="lista-usuarios" class="content-section bg-white shadow-lg p-4">
            <h2>Usuarios</h2>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-auto col-md-6">
                    <div class="input-group mb-3">
                        <input id="usuarioBusqueda" type="text" class="form-control" placeholder="Buscar"
                            aria-label="Buscar">
                        <button class="btn btn-outline-secondary" title="" type="button" id="btnBuscarUsuario"
                            onclick="buscarUsuario()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table id="tablaUsuarios" class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Código</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-sm btn-primary mt-3" title="" data-bs-toggle="modal" data-bs-target="#usuarioModal"
                onclick="btnNuevoUsuario()">
                NUEVO
            </button>
        </section>

        <!-- Seccion de Departamentos -->
        <section id="departamentos" class="content-section bg-white shadow-lg p-4">
            <h2>Departamentos</h2>
            <hr>
            <div class="table-resposive" style="max-height: 40em; overflow-y: auto;">
                <table id="tablaDepartamentos" class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Codigo</th>
                            <th>Departamento</th>
                            <th>Comisión</th>
                            <th>Jefe Del Area</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-sm btn-primary mt-3" title="" data-bs-toggle="modal" data-bs-target="#departamentoModal"
                onclick="btnNuevoDepartamento()">
                NUEVO
            </button>
        </section>

        <!-- Seccion de Roles -->
        <section id="roles" class="content-section bg-white shadow-lg p-4">
            <h2>Roles</h2>
            <hr>
            <div class="table-resposive" style="max-height: 40em; overflow-y: auto;">
                <table id="tablaRoles" class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Nomina</th>
                            <th>Empleados</th>
                            <th>Menu</th>
                            <th>Reportes</th>
                            <th>Caja</th>
                            <th>Prestamos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-sm btn-primary mt-3" title="" data-bs-toggle="modal" data-bs-target="#modalRol"
                onclick="btnNuevoRol()">
                NUEVO
            </button>
        </section>

        <!-- Seccion de Comisiones -->
        <section id="comisiones" class="content-section bg-white shadow-lg p-4">
            <h2>Comisiones</h2>
            <hr>
            <div class="table-resposive" style="max-height: 40em; overflow-y: auto;">
                <table id="tablaComisiones" class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Código</th>
                            <th>Nombre Comisión</th>
                            <th>Restricciones</th>
                            <th>Bono Comision</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-sm btn-primary mt-3" title="" data-bs-toggle="modal" data-bs-target="#modalComision"
                onclick="btnNuevaComision()">
                NUEVO
            </button>
        </section>
    </div>

    <!-- Modal Empleado -->
    <div class="modal fade" id="empleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalEmpleado">Editar Empleado</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertaExitoEmpleado" class="row m-2" hidden>
                        <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                            correctamente</span>
                    </div>
                    <div id="alertaErrorEmpleado" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Ocurrio un error,
                            comuniquese con soporte</span>
                    </div>
                    <div id="alertaNoAfectacionEmpleado" class="row m-2" hidden>
                        <span class="bg-info bg-opacity-75 p-2 text-center text-white rounded-4">No se realizaron
                            cambios</span>
                    </div>
                    <div id="alertaDuplicadoEmpleado" class="row m-2" hidden>
                        <span class="bg-warning p-2 text-center text-white rounded-4">Ya existe un
                            empleado
                            con el DPI ingresado
                        </span>
                    </div>
                    <div id="alertaAsignacionUsuario" class="row m-2" hidden>
                        <span class="bg-warning p-2 text-center text-white rounded-4">El usuario que se
                            desea asignar, ya está en uso
                        </span>
                    </div>
                    <div id="alertaCompletarCamposEmpleado" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Llene todos los
                            campos</span>
                    </div>
                    <form id="formEmpleado">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="foto" class="form-label">Fotografía:</label>
                                <input type="file" class="form-control" id="foto" name="foto" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="CodigoEmpleado" class="form-label">Código de Empleado:</label>
                                <input type="text" class="form-control" id="CodigoEmpleado" name="CodigoEmpleado"
                                    placeholder="00000" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="NombresEmpleado" class="form-label">*Nombres:</label>
                                <input type="text" class="form-control" id="NombresEmpleado" name="NombresEmpleado"
                                    placeholder="Nombre" maxlength="45" required>
                            </div>
                            <div class="col-md-6">
                                <label for="ApellidosEmpleado" class="form-label">*Apellidos:</label>
                                <input type="text" class="form-control" id="ApellidosEmpleado" name="ApellidosEmpleado"
                                    placeholder="Apellidos" maxlength="45" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="Dpi" class="form-label">*DPI:</label>
                                <input type="text" class="form-control" id="Dpi" name="Dpi"
                                    placeholder="0000 0000 0000 0000" maxlength="13" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Nit" class="form-label">NIT:</label>
                                <input type="text" class="form-control" id="Nit" name="Nit"
                                    placeholder="12345678-K ó 123456731" maxlength="13">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="EmailEmpleado" class="form-label">*Correo Electrónico:</label>
                                <input type="email" class="form-control" id="EmailEmpleado" name="EmailEmpleado"
                                    placeholder="ejemplo@email.com" max-length="50" required>
                            </div>

                            <div class="col-md-6">
                                <label for="Telefono" class="form-label">*Número de Teléfono:</label>
                                <input type="number" class="form-control" id="Telefono" name="Telefono"
                                    placeholder="GT 8 digitos" oninput="limitarValor(this, 8);">
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="Profesion" class="form-label">*Profesión:</label>
                                <input type="text" class="form-control" id="Profesion" name="Profesion"
                                    placeholder="Profesion/Puesto" maxlength="45" required>
                            </div>
                            <div class="col-md-6">
                                <label for="SelectEmpleadoDepartamento" class="form-label">*Departamento:</label>
                                <select class="form-select" id="SelectEmpleadoDepartamento"
                                    name="SelectEmpleadoDepartamento">
                                    <option value="" selected disabled>Seleccione un Departamento</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="FechaIngreso" class="form-label">*Fecha de Ingreso:</label>
                                <input type="date" class="form-control" id="FechaIngreso" name="FechaIngreso" required>
                            </div>
                            <div class="col-md-4">
                                <label for="FechaRetiro" class="form-label">Fecha de Retiro:</label>
                                <input type="date" class="form-control" id="FechaRetiro" name="FechaRetiro">
                            </div>
                            <div class="col-md-4">
                                <label for="FechaNacimiento" class="form-label">*Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="FechaNacimiento" name="FechaNacimiento"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="SalarioBase" class="form-label">*Salario:</label>
                                <input type="number" class="form-control" id="SalarioBase" name="SalarioBase"
                                    placeholder="00.00" oninput="limitarValor(this, 8)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Irtra" class="form-label">Carnet de IRTRA:</label>
                                <input type="text" class="form-control" id="Irtra" name="Irtra"
                                    placeholder="1234 5678 9012 3456">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="Igss" class="form-label">Carnet de IGSS:</label>
                                <input type="text" class="form-control" id="Igss" name="Igss"
                                    placeholder="0000 0000 0000 0000" maxlength="13">
                            </div>
                            <div class="col-md-6">
                                <label for="Estado" class="form-label">*Estado:</label>
                                <select class="form-select" id="Estado" name="Estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="SelectEmpleadoJornada" class="form-label">*Jornada:</label>
                                <select class="form-select" id="SelectEmpleadoJornada" name="SelectEmpleadoJornada">
                                    <option value="" selected disabled>Seleccione una Jornada Laboral</option>
                                    <option value="1">Lunes a Viernes</option>
                                    <option value="2">Lunes a Sabado</option>
                                    <option value="3">Domingo a Viernes</option>
                                    <option value="4">Viernes a Miercoles</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="SelectEmpleadoUsuarioSistema" class="form-label">*Usuario Sistema:</label>
                                <select class="form-select" id="SelectEmpleadoUsuarioSistema"
                                    name="SelectEmpleadoUsuarioSistema">
                                    <option value="" selected disabled>Seleccione un Usuario de Sistema</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnGuardarEmpleado" type="button" class="btn btn-sm btn-primary"
                        onclick="guardarEmpleado()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Usuario -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalUsuario">Usuario</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertaExitoUsuario" class="row m-2" hidden>
                        <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                            correctamente</span>
                    </div>
                    <div id="alertaErrorUsuario" class="row m-2" hidden>
                        <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Ocurrio un error,
                            comuniquese con soporte</span>
                    </div>
                    <div id="alertaDuplicadoUsuario" class="row m-2" hidden>
                        <span class="bg-warning p-2 text-center text-white rounded-4">Ya existe un Usuario
                            con el mismo E-mail, intente con otro</span>
                    </div>
                    <div id="alertaCompletarCamposUsuario" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Llene todos los
                            campos</span>
                    </div>
                    <div id="alertaNoAfectacionUsuario" class="row m-2" hidden>
                        <span class="bg-info bg-opacity-75 p-2 text-center text-white rounded-4">No se realizaron
                            cambios</span>
                    </div>
                    <form id="formUsuario">
                        <div class="mb-3">
                            <label for="codigoUsuario" class="form-label">Codigo</label>
                            <input type="number" class="form-control" id="codigoUsuario" name="codigoUsuario"
                                placeholder="#0" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="emailUsuario" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailUsuario" name="email"
                                placeholder="ejemplo@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label id="lblClave" for="claveUsuario" class="form-label">Clave</label>
                            <input type="password" class="form-control" id="claveUsuario" name="clave"
                                placeholder="********">
                        </div>
                        <div class="mb-3">
                            <label for="selectUsuarioRol" class="form-label">Rol</label>
                            <select id="selectUsuarioRol" class="form-select" aria-label="Seleccionar Empleado">
                                <option value="" selected disabled>Seleccione un rol para el usuario</option>
                            </select>
                        </div>
                        <button id="btnGuardarUsuario" title="" type="button" class="btn btn-sm btn-primary"
                            onclick="guardarUsuario()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Departamento -->
    <div class="modal fade" id="departamentoModal" tabindex="-1" aria-labelledby="modalDepartamento">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalDepartamento">Departamento</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertaExitoDepartamento" class="row m-2" hidden>
                        <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                            correctamente</span>
                    </div>
                    <div id="alertaErrorDepartamento" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Ocurrio un error,
                            comuniquese con soporte</span>
                    </div>
                    <div id="alertaDuplicadoDepartamento" class="row m-2" hidden>
                        <span class="bg-warning p-2 text-center text-white rounded-4">Ya existe un
                            departamento con este nombre</span>
                    </div>
                    <div id="alertaNoAfectacionDepartamento" class="row m-2" hidden>
                        <span class="bg-info bg-opacity-75 p-2 text-center text-white rounded-4">No se realizaron
                            cambios</span>
                    </div>
                    <div id="alertaCompletarCamposDepartamento" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Llene todos los
                            campos</span>
                    </div>
                    <form id="formDepartamento">
                        <div class="mb-3">
                            <label for="codigoDepartamento" class="form-label">Código</label>
                            <input type="number" class="form-control" id="codigoDepartamento" name="codigoDepartamento"
                                placeholder="#0" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="nombreDepartamento" class="form-label">Nombre: </label>
                            <input type="text" class="form-control" id="nombreDepartamento" name="nombreDepartamento"
                                placeholder="Nombre para el departamento" required>
                        </div>
                        <div class="mb-3">
                            <label for="selectDepartamentoComision" class="form-label">Comisión:</label>
                            <select id="selectDepartamentoComision" class="form-select">
                                <option value="" selected disabled>Seleccione una comisión</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="selectDepartamentoJefe" class="form-label">Jefe del Departamento</label>
                            <select id="selectDepartamentoJefe" class="form-select">
                                <option value="" selected disabled>Seleccione un Jefe</option>
                            </select>
                        </div>
                        <button id="btnGuardarDepartamento" title="" type="button" class="btn btn-sm btn-primary"
                            onclick="guardarDepartamento()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Rol -->
    <div class="modal fade" id="modalRol" tabindex="-1" aria-labelledby="modalRol">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalRol">Rol</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertaExitoRol" class="row m-2" hidden>
                        <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                            correctamente</span>
                    </div>
                    <div id="alertaErrorRol" class="row m-2" hidden>
                        <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Ocurrio un error,
                            comuniquese con soporte</span>
                    </div>
                    <div id="alertaDuplicadoRol" class="row m-2" hidden>
                        <span class="bg-warning p-2 text-center text-white rounded-4">Ya existe un Rol
                            con el nombre actual</span>
                    </div>
                    <div id="alertaNoAfectacionRol" class="row m-2" hidden>
                        <span class="bg-info bg-opacity-75 p-2 text-center text-white rounded-4">No se realizaron
                            cambios</span>
                    </div>
                    <div id="alertaCompletarCamposRol" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Llene todos los
                            campos</span>
                    </div>
                    <form id="formRol">
                        <div class="mb-3">
                            <label for="nombreRol" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="nombreRol" name="nombreRol" placeholder="Nombre"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permisos</label>
                            <span id="codigoRol" hidden></span>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestionaNomina" name="permiso[]">
                                <label class="form-check-label" for="gestionaNomina">Gestiona Nómina</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestionaEmpleados" name="permiso[]">
                                <label class="form-check-label" for="gestionaEmpleados">Gestiona Empleado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestionaMenu" name="permiso[]">
                                <label class="form-check-label" for="gestionaMenu">Gestiona Menú</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestionaReportes" name="permiso[]">
                                <label class="form-check-label" for="gestionaReportes">Gestiona Reportes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestionaCaja" name="permiso[]">
                                <label class="form-check-label" for="gestionaCaja">Gestiona Caja</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestionaPrestamos" name="permiso[]">
                                <label class="form-check-label" for="gestionaPrestamos">Gestiona Prestamos</label>
                            </div>
                        </div>
                        <button id="btnGuardarRol" title="" type="button" class="btn btn-sm btn-primary"
                            onclick="guardarRol()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Comisiones -->
    <div class="modal fade" id="modalComision" tabindex="-1" aria-labelledby="modalComision">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalComision">Nueva Comisión</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertaExitoComision" class="row m-2" hidden>
                        <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                            correctamente</span>
                    </div>
                    <div id="alertaErrorComision" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Ocurrio un error,
                            comuniquese con soporte</span>
                    </div>
                    <div id="alertaCompletarCamposComision" class="row m-2" hidden>
                        <span class="bg-danger p-2 text-center text-white rounded-4">Llene todos los
                            campos</span>
                    </div>
                    <div id="alertaNoAfectacionComision" class="row m-2" hidden>
                        <span class="bg-info bg-opacity-75 p-2 text-center text-white rounded-4">No se realizaron
                            cambios</span>
                    </div>
                    <div id="alertaDuplicadoComision" class="row m-2" hidden>
                        <span class="bg-warning p-2 text-center text-white rounded-4">Ya existe una
                            comision con este nombre</span>
                    </div>
                    <form id="formComision">
                        <div class="mb-3">
                            <label for="codigoComision" class="form-label">Código</label>
                            <input type="number" class="form-control" id="codigoComision" name="codigoComision"
                                placeholder="#0" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="nombreComsion" class="form-label">Nombre Comisión</label>
                            <input type="text" class="form-control" id="nombreComision" name="nombreComision"
                                placeholder="Nombre de la comisión" required>
                        </div>
                        <div class="mb-3">
                            <label for="restriccionesComision" class="form-label">Restricciones</label>
                            <input type="text" class="form-control" id="restriccionesComision"
                                name="restriccionesComision" placeholder="Ej: Por X piezas descontar el 10%" required>
                        </div>
                        <div class="mb-3">
                            <label for="bonoComision" class="form-label">Bono Comisión</label>
                            <input type="number" class="form-control" id="bonoComision" name="bonoComision"
                                placeholder="Q.00.00" required>
                        </div>
                        <button id="btnGuardarComision" type="button" class="btn btn-sm btn-primary"
                            onclick="guardarComision()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminar Usuario -->
    <div class="modal fade" id="eliminarUsuario" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarUsuarioModalTitle">Eliminar Usuario</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><span id="codigoEliminarUsuario" hidden></span> ¿Estás seguro de que deseas eliminar el registro:
                        <span id="descripcionEliminarUsuario"></span>?
                    </p>
                    <span id="lblErrorEliminarUsuario" class="text-danger" hidden>No se pudo realizar la operacion,
                        comuniquese
                        con soporte</span>
                    <span id="lblExitoEliminarUsuario" class="text-success" hidden>La operacion se realizo con
                        exito</span>
                </div>
                <div class="modal-footer">
                    <button id="cancelarEliminarUsuario" title="" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarEliminarUsuario" title="" type="button" class="btn btn-danger"
                        onclick="eliminarUsuario()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación Rol -->
    <div class="modal fade" id="eliminarRol" tabindex="-1" aria-labelledby="eliminarRol">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Rol</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><span id="codigoEliminarRol" hidden></span> ¿Estás seguro de que deseas eliminar el registro:
                        <span id="descripcionEliminarRol"></span>?
                    </p>
                    <span id="lblErrorEliminarRol" class="text-danger" hidden>No se pudo realizar la operacion,
                        comuniquese
                        con soporte</span>
                    <span id="lblExitoEliminarRol" class="text-success" hidden>La operacion se realizo con exito</span>
                </div>
                <div class="modal-footer">
                    <button id="cancelarEliminarRol" title="" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarEliminarRol" title="" type="button" class="btn btn-danger"
                        onclick="eliminarRol()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación Comision  -->
    <div class="modal fade" id="eliminarComision" tabindex="-1" aria-labelledby="eliminarComision">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Comisión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><span id="codigoEliminarComision" hidden></span> ¿Estás seguro de que deseas eliminar el
                        registro:
                        <span id="descripcionEliminarComision"></span>?
                    </p>
                    <span id="lblErrorEliminarComision" class="text-danger" hidden>No se pudo realizar la operacion,
                        comuniquese
                        con soporte</span>
                    <span id="lblExitoEliminarComision" class="text-success" hidden>La operacion se realizo con
                        exito</span>
                </div>
                <div class="modal-footer">
                    <button id="cancelarEliminarComision" title="" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarEliminarComision" title="" type="button" class="btn btn-danger"
                        onclick="eliminarComision()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación Departamento  -->
    <div class="modal fade" id="eliminarDepartamentoModal" tabindex="-1" aria-labelledby="eliminarDepartamento">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Departamento</h5>
                    <button type="button" title="" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><span id="codigoEliminarDepartamento" hidden></span> <span id="leyendaConfirmacionEliminarDepartamento" hidden> ¿Estás seguro de que deseas eliminar el
                        Departamento: 
                        <span id="descripcionEliminarDepartamento"></span>?</span>
                    </p>
                    <span id="lblErrorEliminarDepartamento" class="text-danger" hidden>No se pudo realizar la operacion,
                        comuniquese
                        con soporte</span>
                    <span id="lblExitoEliminarDepartamento" class="text-success" hidden>La operacion se realizo con
                        exito</span>
                </div>
                <div class="modal-footer">
                    <button id="cancelarEliminarDepartamento" title="" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarEliminarDepartamento" title="" type="button" class="btn btn-danger"
                        onclick="eliminarDepartamento()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../js/funciones-recursos-humanos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');
            const contentSections = document.querySelectorAll('.content-section');
            const regresarLink = document.getElementById('regresar');

            // Función para ocultar todas las secciones excepto la lista de usuarios
            function hideAllSectionsExceptListaUsuarios() {
                contentSections.forEach(section => {
                    if (section.id === 'empleados') {
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