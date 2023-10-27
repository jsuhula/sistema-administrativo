document.addEventListener("DOMContentLoaded", function () {
    var btnIniciarSesion = document.getElementById("btnIniciarSesion");

    btnIniciarSesion.addEventListener("click", function (event) {
        event.preventDefault();
        iniciarSesion();
    });
});


function iniciarSesion() {

    let credenciales = document.getElementById('formCredenciales');

    let datos = {
        email: credenciales.email.value,
        clave: credenciales.clave.value
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/login-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            switch (data) {
                case 1:
                    window.location.reload();
                    break;
                case -1:
                    document.getElementById('alertaCredenciales').removeAttribute('hidden');
                    document.getElementById('alertaCredencialesVacias').setAttribute('hidden', true);
                    break;
                case 0:
                    document.getElementById('alertaCredencialesVacias').removeAttribute('hidden');
                    document.getElementById('alertaCredenciales').setAttribute('hidden', true);
                    break;
            }
        } else {
           console.log(xhr.responseText);
        }
    };

    xhr.send(JSON.stringify(datos));
}
