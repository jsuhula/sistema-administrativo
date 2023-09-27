(function () {

    cargarUsuarios();
    cargarRoles();

})();

/* CARGA LA LISTA DE USUARIOS REALIZANDO LA PETICION AL SERVIDOR */
function cargarUsuarios() {
    var xhr = new XMLHttpRequest();

    var url = "../controllers/usuario-controller.php?option=" + encodeURIComponent(1);
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            var tabla = document.getElementById("tablaUsuarios").getElementsByTagName("tbody")[0];

            /* BORRA LA TABLA PARA QUE ESTA NO SE DUPLIQUE AL LISTAR LOS REGISTROS */
            borrarContenidoTabla();

            data.forEach(function (usuario, index) {
                var row = tabla.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                cell1.innerHTML = usuario.Codigo;
                cell2.innerHTML = usuario.Email;
                cell3.innerHTML = usuario.Rol;
                cell4.innerHTML = '<td>' +
                    '<button type="button" class="btn btn-success btn-sm ms-1 edit-button" data-bs-toggle="modal" data-bs-target="#usuarioModal" data-codigo="' + usuario.Codigo + '" data-email="' + usuario.Email + '" data-rol="' + usuario.CodigoRol + '">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button" data-bs-toggle="modal" data-bs-target="#eliminar" data-codigo="' + usuario.Codigo + '" data-email="' + usuario.Email + '">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</td>';
            });

            var editButtons = document.querySelectorAll(".edit-button");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    ocultarAlertasUsuario();
                    document.getElementById('btnGuardarUsuario').removeAttribute('hidden');
                    // Obtén los datos personalizados del botón
                    let titulo = document.getElementById("editarUsuarioModalLabel");
                    titulo.innerHTML = "Editar Usuario";
                    let labelClaveEditar = document.getElementById("lblClave");
                    labelClaveEditar.innerHTML = "Clave (dejar en blanco si no se requiere modificar)";

                    var codigo = button.getAttribute("data-codigo");
                    var email = button.getAttribute("data-email");
                    var rol = button.getAttribute("data-rol");

                    // Rellena los campos del modal con los datos obtenidos
                    document.getElementById("codigoUsuario").value = codigo;
                    document.getElementById("emailUsuario").value = email;
                    document.getElementById("selectUsuario").value = rol;
                });
            });

            var editButtons = document.querySelectorAll(".delete-button");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    ocultarAlertasEliminar();
                    let codigo = button.getAttribute("data-codigo");
                    let email = button.getAttribute("data-email");

                    // Rellena los campos del modal con los datos obtenidos
                    let eliminarModalEmail = document.getElementById("descripcionEliminar");
                    eliminarModalEmail.innerHTML = email;
                    let codigoEliminar = document.getElementById('codigoEliminar');
                    codigoEliminar.innerHTML = codigo;
                });
            });

        } else {
            alert("Error al eliminar");
        }
    };

    xhr.send();
}

function cargarRoles() {

    var selectIds = ["selectUsuarioBusqueda", "selectUsuario"];

    selectIds.forEach(function (selectId) {
        var xhr = new XMLHttpRequest();
        var url = "../controllers/usuario-controller.php?option=" + encodeURIComponent(2);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                var select = document.getElementById(selectId);

                data.forEach(function (item) {
                    var option = document.createElement("option");
                    option.value = item.CodigoRol;
                    option.text = item.Nombre;
                    select.appendChild(option);
                });
            } else {
                alert("Error al cargar los datos.");
            }
        };

        xhr.send();
    });
}

function borrarContenidoTabla() {
    var tabla = document.getElementById("tablaUsuarios");
    var tbody = tabla.getElementsByTagName("tbody")[0];

    // Borra todas las filas del cuerpo de la tabla
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
}

function nuevoUsuario() {

    ocultarAlertasUsuario();
    document.getElementById('btnGuardarUsuario').removeAttribute('hidden');
    let titulo = document.getElementById("editarUsuarioModalLabel");
    titulo.innerHTML = "Nuevo Usuario";

    let labelClaveEditar = document.getElementById("lblClave");
    labelClaveEditar.innerHTML = "Clave";
    document.getElementById("codigoUsuario").value = "";
    document.getElementById("emailUsuario").value = "";
    document.getElementById("selectUsuario").value = 0;
}

function guardarUsuario() {

    let codigo = document.getElementById('codigoUsuario').value;
    let email = document.getElementById('emailUsuario').value;
    let clave = document.getElementById('claveUsuario').value;
    let rol = document.getElementById('selectUsuario').value;

    console.log(codigo === "");
    console.log(rol);

    if (email === "" || clave === "" & codigo === "" || parseInt(rol) === 0) {
        document.getElementById('alertaCompletarCampos').removeAttribute('hidden');
    } else if (codigo === "") {

        let datos = {
            codigo: codigo,
            clave: clave,
            email: email,
            rol: rol,
            option: 1
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/usuario-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            if (xhr.status === 200) {
                alertaExitoUsuario();
                cargarUsuarios();
                limpiarCamposUsuarioModal();
                document.getElementById('btnGuardarUsuario').setAttribute('hidden', true);
            } else {
                alertaErrorUsuario();
            }
        };
        xhr.send(JSON.stringify(datos));

    } else if (codigo !== "") {
        let datos = {
            codigo: codigo,
            clave: clave,
            email: email,
            rol: rol,
            option: 2
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/usuario-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            if (xhr.status === 200) {
                alertaExitoUsuario();
                cargarUsuarios();
                limpiarCamposUsuarioModal();
                document.getElementById('btnGuardarUsuario').setAttribute('hidden', true);
            } else {
                alertaErrorUsuario();
            }
        };
        xhr.send(JSON.stringify(datos));
    }
}

function eliminarUsuario() {
    var codigo = document.getElementById('codigoEliminar').textContent;
    let datos = {
        codigo: codigo,
        option: 3
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/usuario-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarUsuarios();
            document.getElementById('confirmarEliminar').setAttribute('hidden', true);
            document.getElementById('cancelarEliminar').setAttribute('hidden', true);
            document.getElementById('lblExitoEliminar').removeAttribute('hidden');
            document.getElementById('lblErrorEliminar').setAttribute('hidden', true);
        } else {
            document.getElementById('lblErrorEliminar').removeAttribute('hidden');
            document.getElementById('lblExitoEliminar').setAttribute('hidden', true);
        }
    };
    xhr.send(JSON.stringify(datos));
}

function limpiarCamposUsuarioModal() {
    document.getElementById('codigoUsuario').value = "";
    document.getElementById('emailUsuario').value = "";
    document.getElementById('claveUsuario').value = "";
    document.getElementById('selectUsuario').value = 0;
}

function ocultarAlertasUsuario() {
    document.getElementById('alertaExito').setAttribute('hidden', true);
    document.getElementById('alertaError').setAttribute('hidden', true);
    document.getElementById('alertaCompletarCampos').setAttribute('hidden', true);
}

function alertaExitoUsuario() {
    document.getElementById('alertaExito').removeAttribute('hidden');
    document.getElementById('alertaError').setAttribute('hidden', true);
    document.getElementById('alertaCompletarCampos').setAttribute('hidden', true);
}

function alertaErrorUsuario() {
    document.getElementById('alertaError').removeAttribute('hidden');
    document.getElementById('alertaExito').setAttribute('hidden', true);
    document.getElementById('alertaCompletarCampos').setAttribute('hidden', true);
}

function ocultarAlertasEliminar() {
    document.getElementById('cancelarEliminar').removeAttribute('hidden');
    document.getElementById('confirmarEliminar').removeAttribute('hidden');
    document.getElementById('lblErrorEliminar').setAttribute('hidden', true);
    document.getElementById('lblExitoEliminar').setAttribute('hidden', true);
}