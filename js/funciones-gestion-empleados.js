(function () {

    cargarUsuarios();
    cargarRoles();
    cargarEmpleados();

})();


function cargarEmpleados() {
    var xhr = new XMLHttpRequest();

    var url = "../controllers/empleado-controller.php?option=" + encodeURIComponent(1);
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            var tabla = document.getElementById("tablaEmpleados").getElementsByTagName("tbody")[0];

            /* BORRA LA TABLA PARA QUE ESTA NO SE DUPLIQUE AL LISTAR LOS REGISTROS */
            borrarContenidoTabla("tablaEmpleados");

            data.forEach(function (empleado) {
                var row = tabla.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);

                cell1.innerHTML = empleado.CodigoEmpleado;
                cell2.innerHTML = empleado.Nombre;
                cell3.innerHTML = empleado.Email;
                cell4.innerHTML = empleado.Departamento;
                cell5.innerHTML = empleado.SalarioBase;
                cell6.innerHTML = empleado.Estado;
                cell7.innerHTML = '<td>' +
                    '<button type="button" class="btn btn-success btn-sm ms-1 edit-button-empleado" data-bs-toggle="modal" data-bs-target="#empleadoModal" data-codigo-empleado="' + empleado.CodigoEmpleado + '" data-nombre="' + empleado.Nombre + '" data-email="' + empleado.Email + '" data-departamento="' + empleado.Departamento + '" data-salario="' + empleado.SalarioBase + '" data-estado="' + empleado.Estado + '">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button-empleado" data-bs-toggle="modal" data-bs-target="#eliminarEmpleadoModal" data-codigo-empleado="' + empleado.CodigoEmpleado + '" data-nombre="' + empleado.Nombre + '">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</td>';
            });

            var editButtons = document.querySelectorAll(".edit-button-empleado");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    ocultarAlertasUsuario();
                    document.getElementById('btnGuardarEmpleado').removeAttribute('hidden');
                    // Obtén los datos personalizados del botón
                    let titulo = document.getElementById("tituloModalEmpleado");
                    titulo.innerHTML = "Editar Empleados";
                    let labelClaveEditar = document.getElementById("lblClave");
                    labelClaveEditar.innerHTML = "Clave (dejar en blanco si no se requiere modificar)";

                    var codigoEmpleado = button.getAttribute("data-codigo-empleado");
                    var nombreEmpleado = button.getAttribute("data-nombre");
                    var emailEmpleado = button.getAttribute("data-email");

                    // Rellena los campos del modal con los datos obtenidos
                    document.getElementById("codigoEmpleado").value = codigoEmpleado;
                    document.getElementById("nombreEmpleado").value = nombreEmpleado;
                    document.getElementById("emailEmpleado").value = emailEmpleado;
                    document.getElementById("emailEmpleado").value = emailEmpleado;
                    document.getElementById("emailEmpleado").value = emailEmpleado;

                });
            });

            var editButtons = document.querySelectorAll(".delete-button-empleado");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    ocultarAlertasEliminarUsuario();
                    let codigo = button.getAttribute("data-codigo-empleado");
                    let email = button.getAttribute("data-nombre");

                    // Rellena los campos del modal con los datos obtenidos
                    let eliminarModalEmail = document.getElementById("descripcionEliminarUsuario");
                    eliminarModalEmail.innerHTML = email;
                    let codigoEliminar = document.getElementById('codigoEliminarUsuario');
                    codigoEliminar.innerHTML = codigo;
                });
            });

        } else {
            console.log("Error");
        }
    };

    xhr.send();
}

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
            borrarContenidoTabla("tablaUsuarios");

            data.forEach(function (usuario) {
                var row = tabla.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                cell1.innerHTML = usuario.Codigo;
                cell2.innerHTML = usuario.Email;
                cell3.innerHTML = usuario.Rol;
                cell4.innerHTML = '<td>' +
                    '<button type="button" class="btn btn-success btn-sm ms-1 edit-button-usuario" data-bs-toggle="modal" data-bs-target="#usuarioModal" data-codigo-usuario="' + usuario.Codigo + '" data-email="' + usuario.Email + '" data-rol="' + usuario.CodigoRol + '">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button-usuario" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal" data-codigo-usuario="' + usuario.Codigo + '" data-email="' + usuario.Email + '">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</td>';
            });

            var editButtons = document.querySelectorAll(".edit-button-usuario");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    ocultarAlertasUsuario();
                    document.getElementById('btnGuardarUsuario').removeAttribute('hidden');
                    // Obtén los datos personalizados del botón
                    let titulo = document.getElementById("tituloModalUsuario");
                    titulo.innerHTML = "Editar Usuario";
                    let labelClaveEditar = document.getElementById("lblClave");
                    labelClaveEditar.innerHTML = "Clave (dejar en blanco si no se requiere modificar)";

                    var codigo = button.getAttribute("data-codigo-usuario");
                    var email = button.getAttribute("data-email");
                    var rol = button.getAttribute("data-rol");

                    // Rellena los campos del modal con los datos obtenidos
                    document.getElementById("codigoUsuario").value = codigo;
                    document.getElementById("emailUsuario").value = email;
                    document.getElementById("selectUsuarioRol").value = rol;
                });
            });

            var editButtons = document.querySelectorAll(".delete-button-usuario");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    ocultarAlertasEliminarUsuario();
                    let codigo = button.getAttribute("data-codigo-usuario");
                    let email = button.getAttribute("data-email");

                    // Rellena los campos del modal con los datos obtenidos
                    let eliminarModalEmail = document.getElementById("descripcionEliminarUsuario");
                    eliminarModalEmail.innerHTML = email;
                    let codigoEliminar = document.getElementById('codigoEliminarUsuario');
                    codigoEliminar.innerHTML = codigo;
                });
            });

        } else {
            console.log("Error");
        }
    };

    xhr.send();
}

function borrarContenidoTabla(nombreTabla) {
    var tabla = document.getElementById("" + nombreTabla + "");
    var tbody = tabla.getElementsByTagName("tbody")[0];

    // Borra todas las filas del cuerpo de la tabla
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
}

function btnNuevoUsuario() {

    ocultarAlertasUsuario();
    document.getElementById('btnGuardarUsuario').removeAttribute('hidden');
    let titulo = document.getElementById("tituloModalUsuario");
    titulo.innerHTML = "Nuevo Usuario";

    let labelClaveEditar = document.getElementById("lblClave");
    labelClaveEditar.innerHTML = "Clave";
    document.getElementById("codigoUsuario").value = "";
    document.getElementById("emailUsuario").value = "";
}

function guardarUsuario() {

    let codigo = document.getElementById('codigoUsuario').value;
    let email = document.getElementById('emailUsuario').value;
    let clave = document.getElementById('claveUsuario').value;
    let rol = document.getElementById('selectUsuarioRol').value;

    if (email === "" || clave === "" & codigo === "" || parseInt(rol) === 0) {
        document.getElementById('alertaCompletarCampos').removeAttribute('hidden');
    } else {
        let option = 0;
        if (codigo === "") {
            option = 1;
        } else {
            option = 2;
        }

        let datos = {
            codigoUsuario: codigo,
            clave: clave,
            email: email,
            rol: rol,
            option: option
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
    let codigoUsuario = document.getElementById('codigoEliminarUsuario').textContent;

    let datos = {
        codigoUsuario: codigoUsuario,
        option: 3
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/usuario-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarUsuarios();
            document.getElementById('confirmarEliminarUsuario').setAttribute('hidden', true);
            document.getElementById('cancelarEliminarUsuario').setAttribute('hidden', true);
            document.getElementById('lblExitoEliminarUsuario').removeAttribute('hidden');
            document.getElementById('lblErrorEliminarUsuario').setAttribute('hidden', true);
        } else {
            document.getElementById('lblErrorEliminarUsuario').removeAttribute('hidden');
            document.getElementById('lblExitoEliminarUsuario').setAttribute('hidden', true);
        }
    };
    xhr.send(JSON.stringify(datos));
}

function cargarRoles() {

    let selectIds = ["selectUsuarioRolBusqueda", "selectUsuarioRol", "tablaRoles"];

    selectIds.forEach(function (selectId) {
        var xhr = new XMLHttpRequest();
        var url = "../controllers/usuario-controller.php?option=" + encodeURIComponent(2);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                if (selectId !== "tablaRoles") {
                    limpiarSelectRoles(selectId);
                    var select = document.getElementById(selectId);

                    data.forEach(function (rol) {
                        var option = document.createElement("option");
                        option.value = rol.CodigoRol;
                        option.text = rol.Nombre;
                        select.appendChild(option);
                    });
                }

                if (selectId === "tablaRoles") {
                    borrarContenidoTabla("tablaRoles");
                    let tabla = document.getElementById("tablaRoles").getElementsByTagName("tbody")[0];
                    data.forEach(function (rol) {
                        var row = tabla.insertRow();
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);
                        var cell7 = row.insertCell(6);
                        var cell8 = row.insertCell(7);
                        var cell9 = row.insertCell(8);

                        cell1.innerHTML = rol.CodigoRol;
                        cell2.innerHTML = rol.Nombre;
                        cell3.innerHTML = rol.GestionaNomina;
                        cell4.innerHTML = rol.GestionaEmpleados;
                        cell5.innerHTML = rol.GestionaMenu;
                        cell6.innerHTML = rol.GestionaReportes;
                        cell7.innerHTML = rol.GestionaCaja;
                        cell8.innerHTML = rol.Asistencia;
                        cell9.innerHTML = '<td>' +
                            '<button type="button" class="btn btn-success btn-sm ms-1 edit-button-rol" data-bs-toggle="modal" data-bs-target="#modalRol" data-codigo-rol="' + rol.CodigoRol + '" data-nombre-rol="' + rol.Nombre + '" data-gestiona-nomina="' + rol.GestionaNomina + '" data-gestiona-empleados="' + rol.GestionaEmpleados + '" data-gestiona-menu="' + rol.GestionaMenu + '" data-gestiona-reportes="' + rol.GestionaReportes + '" data-gestiona-caja="' + rol.GestionaCaja + '" data-asistencia="' + rol.Asistencia + '">' +
                            '<i class="fas fa-edit"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button-rol" data-bs-toggle="modal" data-bs-target="#eliminarRol" data-codigo-rol="' + rol.CodigoRol + '" data-nombre-rol="' + rol.Nombre + '">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</td>';
                    });
                }

                var editButtons = document.querySelectorAll(".edit-button-rol");
                editButtons.forEach(function (button) {
                    button.addEventListener("click", function () {

                        limpiarCamposRolModal();
                        ocultarAlertasRol();
                        document.getElementById('btnGuardarRol').removeAttribute('hidden');
                        // Obtén los datos personalizados del botón
                        let titulo = document.getElementById("tituloModalRol");
                        titulo.innerHTML = "Editar Rol";

                        let codigoRol = button.getAttribute("data-codigo-rol");
                        let nombreRol = button.getAttribute("data-nombre-rol");
                        let gestionaNomina = button.getAttribute("data-gestiona-nomina");
                        let gestionaEmpleados = button.getAttribute("data-gestiona-empleados");
                        let gestionaMenu = button.getAttribute("data-gestiona-menu");
                        let gestionaReportes = button.getAttribute("data-gestiona-reportes");
                        let gestionaCaja = button.getAttribute("data-gestiona-caja");
                        let asistencia = button.getAttribute("data-asistencia");

                        // Rellena los campos del modal con los datos obtenidos
                        let codigoRolHidden = document.getElementById("codigoRol");
                        codigoRolHidden.innerHTML = codigoRol;
                        document.getElementById("nombreRol").value = nombreRol;
                        document.getElementById("gestionaNomina").checked = (gestionaNomina === "1");
                        document.getElementById("gestionaEmpleados").checked = (gestionaEmpleados === "1");
                        document.getElementById("gestionaMenu").checked = (gestionaMenu === "1");
                        document.getElementById("gestionaReportes").checked = (gestionaReportes === "1");
                        document.getElementById("gestionaCaja").checked = (gestionaCaja === "1");
                        document.getElementById("asistencia").checked = (asistencia === "1");
                    });
                });

                var editButtons = document.querySelectorAll(".delete-button-rol");
                editButtons.forEach(function (button) {
                    button.addEventListener("click", function () {

                        ocultarAlertasEliminarRol();
                        let codigo = button.getAttribute("data-codigo-rol");
                        let email = button.getAttribute("data-nombre-rol");

                        // Rellena los campos del modal con los datos obtenidos
                        let eliminarModalEmail = document.getElementById("descripcionEliminarRol");
                        eliminarModalEmail.innerHTML = email;
                        let codigoEliminar = document.getElementById('codigoEliminarRol');
                        codigoEliminar.innerHTML = codigo;
                    });
                });

            } else {
                console.log("Error");
            }
        };

        xhr.send();
    });
}

function limpiarSelectRoles(selectId) {

    var select = document.getElementById(selectId);
    // Eliminar todas las opciones del select
    while (select.options.length > 0) {
        select.remove(0);
    }
}

function btnNuevoRol() {

    limpiarCamposRolModal();
    ocultarAlertasRol();
    document.getElementById('btnGuardarRol').removeAttribute('hidden');
    let titulo = document.getElementById("tituloModalRol");
    titulo.innerHTML = "Nuevo Rol";
    let codigoRol = document.getElementById("codigoRol");
    codigoRol.innerHTML = "";

}

function guardarRol() {
    let formulario = document.getElementById("formRol");
    let checkboxes = formulario.querySelectorAll('input[name="permiso[]"]');
    let codigoRolHidden = document.getElementById("codigoRol").textContent;
    let nombreRol = document.getElementById("nombreRol").value;
    let option = 0;

    checkboxes.forEach(function (checkbox) {
        checkbox.value = checkbox.checked ? 1 : 0;
    });

    var permisosArray = Array.from(checkboxes, function (checkbox) {
        return checkbox.value;
    });

    if (codigoRolHidden === "") {
        option = 4
    } else {
        option = 5;
    }

    var datos = {
        codigoRol: codigoRolHidden,
        nombreRol: nombreRol,
        permisos: permisosArray,
        option: option,
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/usuario-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.status === 200) {
            cargarRoles();
            alertaExitoRol();
            document.getElementById('btnGuardarRol').setAttribute('hidden', true);
        } else {
            alertaErrorRol();
        }
    };

    // Enviamos los datos al formulario
    xhr.send(JSON.stringify(datos));
}

function eliminarRol() {
    var codigoRol = document.getElementById('codigoEliminarRol').textContent;
    let datos = {
        codigoRol: codigoRol,
        option: 6
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/usuario-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarRoles();
            document.getElementById('confirmarEliminarRol').setAttribute('hidden', true);
            document.getElementById('cancelarEliminarRol').setAttribute('hidden', true);
            document.getElementById('lblExitoEliminarRol').removeAttribute('hidden');
            document.getElementById('lblErrorEliminarRol').setAttribute('hidden', true);
        } else {
            document.getElementById('lblErrorEliminarRol').removeAttribute('hidden');
            document.getElementById('lblExitoEliminarRol').setAttribute('hidden', true);
        }
    };
    xhr.send(JSON.stringify(datos));
}

function limpiarCamposUsuarioModal() {
    document.getElementById('codigoUsuario').value = "";
    document.getElementById('emailUsuario').value = "";
    document.getElementById('claveUsuario').value = "";
    var selectElement = document.getElementById('selectUsuarioRol');

    // Verifica si el select tiene al menos una opción
    if (selectElement.options.length > 0) {
        // Establece el valor del select en el valor de la primera opción
        selectElement.value = selectElement.options[0].value;
    }
}

function limpiarCamposRolModal() {
    document.getElementById("nombreRol").value = "";
    document.getElementById("gestionaNomina").checked = 0;
    document.getElementById("gestionaEmpleados").checked = 0;
    document.getElementById("gestionaMenu").checked = 0;
    document.getElementById("gestionaReportes").checked = 0;
    document.getElementById("gestionaCaja").checked = 0;
    document.getElementById("asistencia").checked = 0;
}

function ocultarAlertasUsuario() {
    document.getElementById('alertaExitoUsuario').setAttribute('hidden', true);
    document.getElementById('alertaErrorUsuario').setAttribute('hidden', true);
    document.getElementById('alertaCompletarCamposUsuario').setAttribute('hidden', true);
}

function ocultarAlertasRol() {
    document.getElementById('alertaExitoRol').setAttribute('hidden', true);
    document.getElementById('alertaErrorRol').setAttribute('hidden', true);
}

function alertaExitoUsuario() {
    document.getElementById('alertaExitoUsuario').removeAttribute('hidden');
    document.getElementById('alertaErrorUsuario').setAttribute('hidden', true);
    document.getElementById('alertaCompletarCamposUsuario').setAttribute('hidden', true);
}

function alertaExitoRol() {
    document.getElementById('alertaExitoRol').removeAttribute('hidden');
    document.getElementById('alertaErrorRol').setAttribute('hidden', true);
}

function alertaErrorUsuario() {
    document.getElementById('alertaErrorUsuario').removeAttribute('hidden');
    document.getElementById('alertaExitoUsuario').setAttribute('hidden', true);
    document.getElementById('alertaCompletarCamposUsuario').setAttribute('hidden', true);
}

function alertaErrorRol() {
    document.getElementById('alertaErrorRol').removeAttribute('hidden');
    document.getElementById('alertaExitoRol').setAttribute('hidden', true);
}

function ocultarAlertasEliminarUsuario() {
    document.getElementById('cancelarEliminarUsuario').removeAttribute('hidden');
    document.getElementById('confirmarEliminarUsuario').removeAttribute('hidden');
    document.getElementById('lblErrorEliminarUsuario').setAttribute('hidden', true);
    document.getElementById('lblExitoEliminarUsuario').setAttribute('hidden', true);
}

function ocultarAlertasEliminarRol() {
    document.getElementById('cancelarEliminarRol').removeAttribute('hidden');
    document.getElementById('confirmarEliminarRol').removeAttribute('hidden');
    document.getElementById('lblErrorEliminarRol').setAttribute('hidden', true);
    document.getElementById('lblExitoEliminarRol').setAttribute('hidden', true);
}