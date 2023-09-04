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
        <span class="display-4">Gestión de Usuarios</span>
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
                        <a id="regresar" class="nav-link" href="/index.php"><i class="fas fa-arrow-left"></i> Regresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="lista-usuarios">Lista de Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="crear-usuario">Crear Usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="asistencia">Asistencia</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">

        <!-- Lista de Usuarios -->
        <section id="lista-usuarios" class="content-section rounded-4 shadow-lg p-4">
            <h3>Lista de Usuarios</h3>
            <table class="table">
                <thead>
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
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                <i class="fas fa-edit"></i> 
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Crear Usuario -->
        <section id="crear-usuario" class="content-section rounded-4 shadow-lg p-4">
            <h3>Crear Usuario</h3>
            <form>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="administrador">Administrador</option>
                        <option value="usuario">Usuario</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
            </form>
        </section>

        <!-- Editar Usuario -->
        <section id="editar-usuario" class="content-section rounded-4 shadow-lg p-4">
            <h3>Editar Usuario</h3>
            <form>
                <div class="mb-3">
                    <label for="nombre-editar" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre-editar" name="nombre-editar" required>
                </div>
                <div class="mb-3">
                    <label for="email-editar" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email-editar" name="email-editar" required>
                </div>
                <div class="mb-3">
                    <label for="rol-editar" class="form-label">Rol</label>
                    <select class="form-select" id="rol-editar" name="rol-editar" required>
                        <option value="administrador">Administrador</option>
                        <option value="usuario">Usuario</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </section>
        <!-- Asistencia -->
        <section id="asistencia" class="content-section rounded-4 shadow-lg p-4">
            <h3>Asistencia</h3>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="nombre-usuario" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="nombre-usuario">
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
            <button class="btn btn-primary" id="buscar-asistencia">Buscar</button>

            <!-- Historial de asistencia -->
            <table class="table mt-3">
                <thead>
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
                </tbody>
            </table>
        </section>
    </div>

    <!-- Modal de Edición de Usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar el usuario -->
                    <form>
                        <div class="mb-3">
                            <label for="nombreEdit" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreEdit" name="nombreEdit" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailEdit" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailEdit" name="emailEdit" required>
                        </div>
                        <div class="mb-3">
                            <label for="rolEdit" class="form-label">Rol</label>
                            <select class="form-select" id="rolEdit" name="rolEdit" required>
                                <option value="administrador">Administrador</option>
                                <option value="usuario">Usuario</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación de Usuario -->
<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarUsuarioModalLabel">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar a este usuario?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');
        const contentSections = document.querySelectorAll('.content-section');
        const regresarLink = document.getElementById('regresar');

        // Función para ocultar todas las secciones excepto la lista de usuarios
        function hideAllSectionsExceptListaUsuarios() {
            contentSections.forEach(section => {
                if (section.id === 'lista-usuarios') {
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

        const fechaSeleccion = document.getElementById('fecha-seleccion');
        const fechaInicioContainer = document.getElementById('fecha-inicio-container');
        const fechaFinContainer = document.getElementById('fecha-fin-container');

        fechaSeleccion.addEventListener('change', function () {
            const seleccion = fechaSeleccion.value;

            fechaInicioContainer.style.display = 'none';
            fechaFinContainer.style.display = 'none';

            if (seleccion === 'personalizado') {
                fechaInicioContainer.style.display = 'block';
                fechaFinContainer.style.display = 'block';
            }
        });

        regresarLink.addEventListener('click', function (event) {
            event.preventDefault();

            window.location.href = '/index.php'; // 
        });
    });
</script>