<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Platillos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <header class="bg-dark text-white text-center py-4">
        <h1 class="display-4">Gestión de Platillos</h1>
    </header>

    <!-- Barra de navegación con estilos de Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../index.php">Regresar</a></li>
            </ul>
        </div>
    </nav>
    <main class="container mt-4">
        <section id="menu" class="bg-white rounded-4 shadow p-4">
            <h2 class="mb-4">Menú Actual</h2>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar platillo" aria-label="Buscar platillo"
                    aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="menu-container" style="max-height: 300px; overflow-y: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-nombre="Platillo 1" data-descripcion="Descripción del platillo 1" data-precio="$10.99">
                            <td>Platillo 1</td>
                            <td>Descripción del platillo 1</td>
                            <td>Q10.99</td>
                            <td>
                                <button class="btn btn-link" data-toggle="modal" data-target="#editarModal"
                                    data-nombre="Platillo 1" data-descripcion="Descripción del platillo 1"
                                    data-precio="$10.99">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-link" data-toggle="modal" data-target="#eliminarModal"
                                    data-nombre="Platillo 1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr data-nombre="Platillo 2" data-descripcion="Descripción del platillo 2" data-precio="$12.99">
                            <td>Platillo 2</td>
                            <td>Descripción del platillo 2</td>
                            <td>Q.12.99</td>
                            <td>
                                <button class="btn btn-link" data-toggle="modal" data-target="#editarModal"
                                    data-nombre="Platillo 2" data-descripcion="Descripción del platillo 2"
                                    data-precio="$12.99">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-link" data-toggle="modal" data-target="#eliminarModal"
                                    data-nombre="Platillo 2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </section>
        <section id="agregar" class="bg-white rounded-4 shadow mt-5 mb-5 p-4 ">
            <h2 class="mb-4">Agregar Nuevo Platillo</h2>
            <form>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Platillo:</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea class="form-control" id="descripcion" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" class="form-control" id="precio" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Platillo</button>
            </form>
        </section>
    </main>
    <footer class="bg-dark text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pt-2">
                    <p>Correo electrónico: ejemplo@correo.com</p>
                </div>
                <div class="col-md-6 pt-2">
                    <p>© 2023 Todos los derechos reservados</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
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