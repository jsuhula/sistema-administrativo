<?php

session_start();
if ($_SESSION) {
  header('location: index.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="resources/food.svg" type="image/svg+xml">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <title>Ingresar</title>
</head>

<body>
  <div class="wrapper">
    <div class="header">
    </div>

    <div class="her d-flex">
      <div class="background move-background hero-image"></div>
      <div class="container container-fluid">
        <div class="vh-100 h-auto row row-cols-auto justify-content-center align-items-center">
          <div class="col-md-auto">
            <div class="card px-5 py-5 bg-white bg-opacity-75 shadow-sm rounded-4 border-0">
              <form id="formCredenciales" method="POST" autocomplete="off">
                <div>
                  <h2 class="fs-3 text-center text-black">Sistema Administrativo </br>¡De Aqui Soy!</h2>
                  <br>
                </div>
                <div class="form-outline mb-4 input-group">
                  <label for="email"
                    class="input-group-text text-black bg-transparent border border-dark border-opacity-50 rounded-5"><i
                      class="fas fa-envelope"></i></label>
                  <input id="email" required
                    class="form-control bg-transparent border border-dark border-start-0 border-top-0 border-end-0 rounded-0 border-opacity-25"
                    type="email" name="user" placeholder="Correo" maxlength="50">
                </div>

                <div class="form-outline mb-4 input-group">
                  <label for="clave"
                    class="input-group-text bg-transparent text-black border border-dark border-opacity-50 rounded-5"><i
                      class="fas fa-key"></i></label>
                  <input id="clave" required
                    class="form-control bg-transparent border border-dark  border-start-0 border-top-0 border-end-0 rounded-0 border-opacity-25"
                    type="password" name="pass" preview="true" placeholder="Contraseña" maxlength="13">
                </div>
                <div id="alertaCredenciales" class="text-center" hidden>
                  <div class="alert border-danger bg-transparent border-opacity-50 rounded-5">
                    <span class="text-danger">Por favor valide sus credenciales</span>
                  </div>
                </div>
                <div id="alertaCredencialesVacias" class="text-center" hidden>
                  <div class="alert border-danger bg-transparent border-opacity-50 rounded-5">
                    <span class="text-danger">Por favor llene todos los campos</span>
                  </div>
                </div>
                <div>
                  <input id="btnIniciarSesion"
                    class="text-center btn btn-outline-dark form-control opacity-75 rounded-5 mt-3 mb-3" type="submit"
                    value="INGRESAR">
                </div>
              </form>
            </div>
            <div class="d-flex justify-content-center text-light">
              <div class="fw-light">
                <p>Desarrollo UMG 2023 &#174;</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
<link rel="stylesheet" href="styles/background-image.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
<script src="js/background.js"></script>
<script src="js/funciones-login.js"></script>

</html>