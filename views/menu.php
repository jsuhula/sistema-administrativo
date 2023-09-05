<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="display-4 text-center mb-5">Menú</h1>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <img class="card-img-top" src="https://w0.peakpx.com/wallpaper/129/948/HD-wallpaper-delicious-food-meal-dish-delicious-food-fries-meat-vegetables-thumbnail.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Nombre del Platillo 1</h4>
                        <p class="card-text">Precio: Q. 50</p>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi dolorem eum dicta, deleniti ab aut numquam voluptatum laudantium eos nesciunt pariatur quidem voluptatem reiciendis soluta at enim, sit ullam. Maxime!
                        </p>
                        <button class="btn btn-warning btn-block text-white" type="button" data-bs-toggle="collapse" data-bs-target="#order1" aria-expanded="false" aria-controls="order1">
                            ORDENAR
                        </button>
                    </div>
                    <div class="collapse" id="order1">
                        <div class="card card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="quantity1" class="form-label">Cantidad:</label>
                                    <input type="number" class="form-control" id="quantity1" name="quantity1" min="1">
                                </div>
                                <div class="mb-3">
                                    <label for="notes1" class="form-label">Notas:</label>
                                    <textarea class="form-control" id="notes1" name="notes1" rows="2"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="drink1" class="form-label">Seleccionar Bebida:</label>
                                    <select class="form-select" id="drink1" name="drink1">
                                        <option value="agua">Agua (Q. 5)</option>
                                        <option value="refresco">Refresco (Q. 10)</option>
                                        <option value="jugo">Jugo (Q. 8)</option>
                                        <option value="te">Té (Q. 7)</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                    Completar Orden
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <img class="card-img-top" src="https://c1.wallpaperflare.com/preview/670/756/865/hotdog-delicious-yummy-fresh-fries.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Nombre del Platillo 2</h4>
                        <p class="card-text">Precio: Q. 40</p>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi dolorem eum dicta, deleniti ab aut numquam voluptatum laudantium eos nesciunt pariatur quidem voluptatem reiciendis soluta at enim, sit ullam. Maxime!
                        </p>
                        <button class="btn btn-warning btn-block text-white" type="button" data-bs-toggle="collapse" data-bs-target="#order2" aria-expanded="false" aria-controls="order2">
                            ORDENAR
                        </button>
                    </div>
                    <div class="collapse" id="order2">
                        <div class="card card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="quantity2" class="form-label">Cantidad:</label>
                                    <input type="number" class="form-control" id="quantity2" name="quantity2" min="1">
                                </div>
                                <div class="mb-3">
                                    <label for="notes2" class="form-label">Notas:</label>
                                    <textarea class="form-control" id="notes2" name="notes2" rows="2"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="drink1" class="form-label">Seleccionar Bebida:</label>
                                    <select class="form-select" id="drink1" name="drink1">
                                        <option value="agua">Agua (Q. 5)</option>
                                        <option value="refresco">Refresco (Q. 10)</option>
                                        <option value="jugo">Jugo (Q. 8)</option>
                                        <option value="te">Té (Q. 7)</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                    Completar Orden
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de confirmación para Platillo 1 -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel2">Confirmar Orden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea ordenar Platillo 2?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="completarOrden(2)">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>