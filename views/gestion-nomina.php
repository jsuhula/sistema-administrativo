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
                            <a id="regresar" class="nav-link" href="/index.php"><i class="fas fa-arrow-left"></i> Regresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#salarios" data-section="salarios">Salarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#informes" data-section="informes">Informes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#comisiones" data-section="comisiones">Comisiones</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        <section id="salarios" class="container bg-white shadow-lg mt-5 mb-5 p-md-5 rounded-4">
            <h2>Empleados</h2>
            <form>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Empleado:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="salario" class="form-label">Salario Mensual:</label>
                    <input type="number" class="form-control" id="salario" name="salario" required>
                </div>
                <button type="submit" class="btn btn-success">Agregar Empleado</button>
            </form>
            <!-- Lista de empleados -->
            <h3>Lista de Empleados</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Salario Mensual</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Empleado 1</td>
                        <td>$2500.00</td>
                        <td>
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Empleado 2</td>
                        <td>$3000.00</td>
                        <td>
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editarModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Cálculo de Salarios -->
        <section id="salarios" class="container bg-white rounded-4 shadow-lg p-4 mt-4" hidden>
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
                        <td>$2500.00</td>
                        <td>$2500.00</td>
                    </tr>
                    <tr>
                        <td>Empleado 2</td>
                        <td>$3000.00</td>
                        <td>$3000.00</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Generación de Informe de Nómina -->
        <section id="informes" class="container bg-white rounded-4 shadow-lg p-4 mt-4" hidden>
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
            <a href="#" class="btn bg-danger bg-opacity-50"><i class="fas fa-download"></i> Descargar Informe</a>
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
            const regresarLink = document.getElementById('regresar');

            const navLinks = document.querySelectorAll('.navbar-nav a.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    if (targetId === 'salarios') {
                        salarios.removeAttribute('hidden');
                        informes.setAttribute('hidden', 'true');
                    } else if (targetId === 'informes') {
                        salarios.setAttribute('hidden', 'true');
                        informes.removeAttribute('hidden');
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