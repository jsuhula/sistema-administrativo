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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                        <a id="regresar" class="nav-link" href="/index.php"><i class="fas fa-arrow-left"></i> Regresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="empleados">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="lista-usuarios">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="asistencia">Asistencia</a>
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
                <input id="nombre-empleado" type="text" class="form-control" placeholder="Buscar por Nombre" aria-label="Buscar Empleado" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <h3>Lista de Empleados</h3>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped">
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
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EM001A</td>
                            <td>Empleado 1</td>
                            <td>empleado@email.com</td>
                            <td>Contabilidad</td>
                            <td>Q.2500.00</td>
                            <td>Activo</td>
                            <td>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">
                Nuevo Empleado
            </button>
        </section>

        <!-- Lista de Usuarios -->
        <section id="lista-usuarios" class="content-section rounded-4 shadow-lg p-4">
            <h3>Lista de Usuarios</h3>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar Empleado" aria-label="Buscar Usuario" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="table-responsive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td>Administrador</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                Nuevo Usuario
            </button>
        </section>

        <!-- Asistencia -->
        <section id="asistencia" class="content-section rounded-4 shadow-lg p-4">
            <h3>Asistencia</h3>
            <div class="row">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Buscar Empleado" aria-label="Buscar Usuario" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="fecha-seleccion" class="form-label">Fecha</label>
                    <select class="form-select" id="fecha-seleccion">
                        <option value="hoy">Hoy</option>
                        <option value="semana">Esta Semana</option>
                        <option value="mes-actual">Mes Actual</option>
                        <option value="mes-pasado">Mes Pasado</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3" id="fecha-inicio-container" style="display: none;">
                    <label for="fecha-inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha-inicio">
                </div>
                <div class="col-md-2 mb-3" id="fecha-fin-container" style="display: none;">
                    <label for="fecha-fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha-fin">
                </div>
            </div>
            <button class="btn btn-success mb-3" id="buscar-asistencia">Buscar</button>

            <!-- Historial de asistencia -->
            <div class="table-resposive" style="max-height: 20em; overflow-y: auto;">
                <table class="table table-striped">
                    <thead class="sticky-top">
                        <tr>
                            <th>Nombre de Usuario</th>
                            <th>Fecha</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Juan Pérez</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Luis Lopez</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Joel Ramos</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Aroldo Pérez</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Amilcar Pobles</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Juan Pérez</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Luis Lopez</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Joel Ramos</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Aroldo Pérez</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Amilcar Pobles</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                        <tr>
                            <td>Juan Pérez</td>
                            <td>2023-09-01</td>
                            <td>09:00 AM</td>
                            <td>05:00 PM</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </div>

    <!-- Modal para editar empleado -->
    <div class="modal fade" id="editarEmpleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEmpleadoModalLabel">Editar Empleado</h5>
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
                                <label for="carnetIrtra" class="form-label">Código de Usuario:</label>
                                <input type="text" class="form-control" id="carnetIrtra" name="carnetIrtra" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del Empleado:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="identificacion" class="form-label">DPI:</label>
                                <input type="text" class="form-control" id="identificacion" name="identificacion" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nit" class="form-label">NIT:</label>
                                <input type="text" class="form-control" id="nit" name="nit">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="correo" class="form-label">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="correo" name="correo">
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
                                <label for="carnetIrtra" class="form-label">Carnet de IRTRA:</label>
                                <input type="text" class="form-control" id="carnetIrtra" name="carnetIrtra">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación -->
    <div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarUsuarioModalLabel">Eliminar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar a este el empleado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edición de Usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="clave" class="form-label">Clave</label>
                            <input type="password" class="form-control" id="clave" name="clave" required>
                        </div>
                        <div class="mb-3">
                            <label for="permisos" class="form-label">Permisos</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestiona-nomina" name="permiso[]" value="gestiona-nomina">
                                <label class="form-check-label" for="gestiona-nomina">Gestiona Nómina</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestiona-empleado" name="permiso[]" value="gestiona-empleado">
                                <label class="form-check-label" for="gestiona-empleado">Gestiona Empleado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestiona-menu" name="permiso[]" value="gestiona-menu">
                                <label class="form-check-label" for="gestiona-menu">Gestiona Menú</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gestiona-reportes" name="permiso[]" value="gestiona-reportes">
                                <label class="form-check-label" for="gestiona-reportes">Gestiona Reportes</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                link.addEventListener('click', function(event) {
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

            const fechaSeleccion = document.getElementById('fecha-seleccion');
            const fechaInicioContainer = document.getElementById('fecha-inicio-container');
            const fechaFinContainer = document.getElementById('fecha-fin-container');

            fechaSeleccion.addEventListener('change', function() {
                const seleccion = fechaSeleccion.value;

                fechaInicioContainer.style.display = 'none';
                fechaFinContainer.style.display = 'none';

                if (seleccion === 'personalizado') {
                    fechaInicioContainer.style.display = 'block';
                    fechaFinContainer.style.display = 'block';
                }
            });

            regresarLink.addEventListener('click', function(event) {
                event.preventDefault();

                window.location.href = '../index.php';
            });
        });
    </script>
</body>

</html>