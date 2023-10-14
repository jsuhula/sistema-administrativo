function cerrarSesion() {
    let datos = {
        salir: 1
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/login-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            if(data === 1){
                window.location.reload();
            }
        }
    };

    xhr.send(JSON.stringify(datos));
}