<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <header class="bg-dark text-white text-center">
        <span class="display-4">Gestión de Empleados</span>
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
                        <a id="regresar" class="nav-link" href="../index.php"><i class="fas fa-arrow-left"></i>
                            Regresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="empleados">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="lista-usuarios">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="roles">Roles</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">

        <!-- Seccion de Empleados -->
        <section id="empleados" class="content-section container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4">
            <h2>Empleados</h2>
            <div class="input-group mb-3">
                <input id="nombre-empleado" type="text" class="form-control" placeholder="Buscar por Nombre"
                    aria-label="Buscar Empleado" aria-describedby="button-addon2">
                <select class="form-select" aria-label="Seleccionar Categoría">
                    <option value="">Todos los Departamentos</option>
                    <option value="categoria1">Departamento 1</option>
                    <option value="categoria2">Departamento 2</option>
                </select>
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
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

            <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#empleadoModal">
                Nuevo Empleado
            </button>
        </section>

        <!-- Lista de Usuarios -->
        <section id="lista-usuarios" class="content-section container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4">
            <h2>Usuarios</h2>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar Usuario" aria-label="Buscar Usuario"
                    aria-describedby="button-addon2">
                <select id="selectUsuarioRolBusqueda" class="form-select" aria-label="Seleccionar Categoría">
                </select>
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="fas fa-search"></i>
                </button>
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
            <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#usuarioModal"
                onclick="btnNuevoUsuario()">
                Nuevo Usuario
            </button>
        </section>

        <!-- Asistencia -->
        <section id="roles" class="content-section container bg-white shadow-lg mt-5 mb-5 p-4 rounded-4">
            <h2>Roles</h2>
            <!-- Lista de Roles-->
            <div class="table-resposive" style="max-height: 20em; overflow-y: auto;">
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
                            <th>Asistencia</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#modalRol"
                onclick="btnNuevoRol()">
                Nuevo Rol
            </button>
        </section>
    </div>

    <!-- Modal empleado -->
    <div class="modal fade" id="empleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalEmpleado">Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="foto" class="form-label">Fotografía:</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>
                            <div class="col-md-6">
                                <label for="codigoEmpleado" class="form-label">Código de Empleado:</label>
                                <input type="text" class="form-control" id="codigoEmpleado" name="codigoEmpleado"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombreEmpleado" class="form-label">Nombre del Empleado:</label>
                                <input type="text" class="form-control" id="nombreEmpleado" name="nombreEmpleado"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dpi" class="form-label">DPI:</label>
                                <input type="text" class="form-control" id="dpi" name="dpi" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nit" class="form-label">NIT:</label>
                                <input type="text" class="form-control" id="nit" name="nit">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="emailEmpleado" class="form-label">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="emailEmpleado" name="emailEmpleado">
                            </div>

                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Número de Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="profesion" class="form-label">Profesión:</label>
                                <input type="text" class="form-control" id="profesion" name="profesion" required>
                            </div>
                            <div class="col-md-6">
                                <label for="departamento" class="form-label">Departamento:</label>
                                <select class="form-select" id="departamento" name="departamento">
                                    <option value="1">Administracion</option>
                                    <option value="2">Contabilidad</option>
                                    <option value="2">Ventas</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fechaIngreso" class="form-label">Fecha de Ingreso:</label>
                                <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaRetiro" class="form-label">Fecha de Retiro:</label>
                                <input type="date" class="form-control" id="fechaRetiro" name="fechaRetiro">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="salario" class="form-label">Salario:</label>
                                <input type="number" class="form-control" id="salario" name="salario" required>
                            </div>
                            <div class="col-md-6">
                                <label for="carnetIrtraModal" class="form-label">Carnet de IRTRA:</label>
                                <input type="text" class="form-control" id="carnetIrtraModal" name="carnetIrtraModal">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="carnetIgss" class="form-label">Carnet de IGSS:</label>
                                <input type="text" class="form-control" id="carnetIgss" name="carnetIgss">
                            </div>
                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado:</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnGuardarEmpleado" type="button" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación -->
    <div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarUsuarioModalLabel">Eliminar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><span id="codigoEliminarUsuario" hidden></span> ¿Estás seguro de que deseas eliminar el registro:
                        <span id="descripcionEliminarUsuario"></span>?</p>
                    <span id="lblErrorEliminarUsuario" class="text-danger" hidden>No se pudo realizar la operacion,
                        comuniquese
                        con soporte</span>
                    <span id="lblExitoEliminarUsuario" class="text-success" hidden>La operacion se realizo con
                        exito</span>
                </div>
                <div class="modal-footer">
                    <button id="cancelarEliminarUsuario" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarEliminarUsuario" type="button" class="btn btn-danger"
                        onclick="eliminarUsuario()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación Rol -->
    <div class="modal fade" id="eliminarRol" tabindex="-1" aria-labelledby="eliminarRol" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button id="cancelarEliminarRol" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarEliminarRol" type="button" class="btn btn-danger"
                        onclick="eliminarRol()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Usuario -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalUsuario">Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <div id="alertaCompletarCamposUsuario" class="row m-2" hidden>
                        <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Llene todos los
                            campos</span>
                    </div>
                    <form>
                        <div class="mb-3">
                            <label for="codigoUsuario" class="form-label">Codigo</label>
                            <input type="number" class="form-control" id="codigoUsuario" name="codigoUsuario"
                                placeholder="#0" disabled required>
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
                            <label for="selectUsuarioRol" class="form-label">Seleccione un rol para el usuario</label>
                            <select id="selectUsuarioRol" class="form-select" aria-label="Seleccionar Categoría">
                            </select>
                        </div>
                        <button id="btnGuardarUsuario" type="button" class="btn btn-success"
                            onclick="guardarUsuario()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Rol -->
    <div class="modal fade" id="modalRol" tabindex="-1" aria-labelledby="modalRol" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalRol">Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formRol">
                        <div id="alertaExitoRol" class="row m-2" hidden>
                            <span class="bg-success bg-opacity-75 p-2 text-center text-white rounded-4">Se guardó
                                correctamente</span>
                        </div>
                        <div id="alertaErrorRol" class="row m-2" hidden>
                            <span class="bg-danger bg-opacity-75 p-2 text-center text-white rounded-4">Ocurrio un error,
                                comuniquese con soporte</span>
                        </div>
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
                                <input class="form-check-input" type="checkbox" id="asistencia" name="permiso[]">
                                <label class="form-check-label" for="asistencia">Asistencia</label>
                            </div>
                        </div>
                        <button id="btnGuardarRol" type="button" class="btn btn-success"
                            onclick="guardarRol()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../js/funciones-gestion-empleados.js"></script>
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