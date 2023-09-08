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
    <header class="bg-dark text-white text-center">
        <span class="display-4">Gestión de Platillos</span>
    </header>
    <!-- Barra de navegación con estilos de Bootstrap -->
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
                        <a class="nav-link" href="#lista-platillos">Menú Actual</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#agregar-nuevo">Agregar Nuevo</a>
                    </li>
                </ul>
            </div>
    </nav>
    <main class="container mt-4">
        <!-- Lista de Platillos -->
        <section id="lista-platillos" class="bg-white rounded-4 shadow p-4">
            <h2 class="mb-4">Menú Actual</h2>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar platillo" aria-label="Buscar platillo" aria-describedby="button-addon2">
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
                                <button class="btn btn-link" data-toggle="modal" data-target="#editarModal" data-nombre="Platillo 1" data-descripcion="Descripción del platillo 1" data-precio="$10.99">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-link" data-toggle="modal" data-target="#eliminarModal" data-nombre="Platillo 1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr data-nombre="Platillo 2" data-descripcion="Descripción del platillo 2" data-precio="$12.99">
                            <td>Platillo 2</td>
                            <td>Descripción del platillo 2</td>
                            <td>Q.12.99</td>
                            <td>
                                <button class="btn btn-link" data-toggle="modal" data-target="#editarModal" data-nombre="Platillo 2" data-descripcion="Descripción del platillo 2" data-precio="$12.99">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-link" data-toggle="modal" data-target="#eliminarModal" data-nombre="Platillo 2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </section>
        <!-- Agregar Nuevo Platillo -->
        <section id="agregar-nuevo" class="bg-white rounded-4 shadow mt-5 mb-5 p-4" hidden>
            <h2 class="mb-4">Agregar Nuevo</h2>
            <form>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" class="form-control" id="imagen" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" class="form-control" id="precio" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del Platillo:</label>
                        <input type="text" class="form-control" id="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="categoria" class="form-label">Categoría:</label>
                        <select class="form-select" id="categoria" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            <option value="Entrada">Entrada</option>
                            <option value="Plato principal">Plato principal</option>
                            <option value="Postre">Postre</option>
                            <option value="Bebida">Bebida</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" rows="2" required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Platillo</button>
            </form>
        </section>

    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;
            const listaPlatillosSection = document.getElementById('lista-platillos');
            const agregarNuevoSection = document.getElementById('agregar-nuevo');
            const regresarLink = document.getElementById('regresar');

            const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    if (targetId === 'lista-platillos') {
                        listaPlatillosSection.removeAttribute('hidden');
                        agregarNuevoSection.setAttribute('hidden', 'true');
                    } else if (targetId === 'agregar-nuevo') {
                        listaPlatillosSection.setAttribute('hidden', 'true');
                        agregarNuevoSection.removeAttribute('hidden');
                    }
                });
            });
            regresarLink.addEventListener('click', function(event) {
                event.preventDefault();

                window.location.href = '../index.php'; // 
            });
        });
    </script>
</body>

</html>