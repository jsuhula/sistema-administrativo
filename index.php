<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>

    <header class="bg-dark text-white text-center">
        <span class="display-4">Administración Restaurante</span>
    </header>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">9
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link"><i class="fas fa-user"></i> User</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/gestion-usuarios.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/gestion-menu.php">Menú</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/reportes.php">Reportes</a>
                    </li>
                    <li class="nav-item text-white">
                        <a class="nav-link" href="views/menu.php" target="_blank">Ver Menú</a>
                    </li>
                </ul>
            </div>
            <div class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#salir">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <div class="container shadow-lg mt-5 mb-5 p-md-5 rounded-4">
        <div class="row mt-4 justify-content-center">
            <div class="col-md-10 pb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Gráfica de Ventas Mensuales</h2>
                        <canvas id="ventasMensuales"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="text-center pt-3">Estadisticas del mes</h2>
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
                        <h2 class="card-title">Platillos Más Vendido</h2>
                        <p>Platillo mas Vendido del Mes e Historicamente:</p>
                        <p><strong>Platillo del Mes: ----------</strong></p>
                        <p><strong>Platillo Historico: --------</strong></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

    <!-- Configura la gráfica de ventas mensuales -->
    <script>
        var ctx = document.getElementById('ventasMensuales').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                datasets: [{
                    label: 'Ventas Mensuales',
                    data: [1200, 1400, 1600, 1800, 2000, 2200],
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const header = document.querySelector('header');
            const headerHeight = header.offsetHeight;

            window.addEventListener('scroll', function() {
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