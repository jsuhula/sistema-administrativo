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
                let row = tabla.insertRow();
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);
                let cell4 = row.insertCell(3);
                let cell5 = row.insertCell(4);
                let cell6 = row.insertCell(5);
                let cell7 = row.insertCell(6);

                cell1.innerHTML = empleado.CodigoEmpleado;
                cell2.innerHTML = empleado.NombreCompleto;
                cell3.innerHTML = empleado.Email;
                cell4.innerHTML = empleado.Departamento;
                cell5.innerHTML = empleado.SalarioBase;
                cell6.innerHTML = empleado.Estado;
                cell7.innerHTML = '<td>' +
                    '<button type="button" class="btn btn-success btn-sm ms-1 edit-button-empleado" data-bs-toggle="modal" data-bs-target="#empleadoModal" ' +
                    'data-codigo-empleado="' + empleado.CodigoEmpleado + '" data-nombres-empleado="' + empleado.Nombres + '" data-apellidos-empleado="' + empleado.Apellidos + '" data-email-empleado="' + empleado.Email + '" data-telefono="' + empleado.Telefono + '" data-salario="' + empleado.SalarioBase +
                    '" data-fecha-nacimiento="' + empleado.FechaNacimiento + '" data-fecha-ingreso="' + empleado.FechaIngreso + '" data-fecha-retiro="' + empleado.FechaRetiro +
                    '" data-profesion="' + empleado.Profesion + '" data-dpi="' + empleado.DPI + '" data-nit="' + empleado.NIT + '" data-irtra="' + empleado.IRTRA + '" data-igss="' + empleado.IGSS +
                    '" data-estado="' + empleado.Estado + '" data-codigo-departamento="' + empleado.CodigoDepartamento + '">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button-empleado" data-bs-toggle="modal" data-bs-target="#eliminarEmpleadoModal" data-codigo-empleado="' + empleado.CodigoEmpleado + '" data-nombres-empleado="' + empleado.Nombres + '" data-apellidos-empleado="' + empleado.Apellidos + '">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</td>';
            });

            var editButtons = document.querySelectorAll(".edit-button-empleado");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    document.getElementById('btnGuardarEmpleado').removeAttribute('hidden');
                    // Obtén los datos personalizados del botón
                    let titulo = document.getElementById("tituloModalEmpleado");
                    titulo.innerHTML = "Editar Empleados";

                    let CodigoEmpleado = button.getAttribute("data-codigo-empleado");
                    let NombresEmpleado = button.getAttribute("data-nombres-empleado");
                    let ApellidosEmpleado = button.getAttribute("data-apellidos-empleado");
                    let EmailEmpleado = button.getAttribute("data-email-empleado");
                    let Telefono = button.getAttribute("data-telefono");
                    let SalarioBase = button.getAttribute("data-salario");
                    let FechaNacimiento = button.getAttribute("data-fecha-nacimiento");
                    let FechaIngreso = button.getAttribute("data-fecha-ingreso");
                    let FechaRetiro = button.getAttribute("data-fecha-retiro");
                    let Profesion = button.getAttribute("data-profesion");
                    let Dpi = button.getAttribute("data-dpi");
                    let Nit = button.getAttribute("data-nit");
                    let Irtra = button.getAttribute("data-irtra");
                    let Igss = button.getAttribute("data-igss");
                    let Estado = button.getAttribute("data-estado");
                    let CodigoDepartamento = button.getAttribute("data-codigo-departamento");

                    // Rellena los campos del modal con los datos obtenidos
                    document.getElementById("CodigoEmpleado").value = CodigoEmpleado;
                    document.getElementById("NombresEmpleado").value = NombresEmpleado;
                    document.getElementById("ApellidosEmpleado").value = ApellidosEmpleado;
                    document.getElementById("EmailEmpleado").value = EmailEmpleado;
                    document.getElementById("SalarioBase").value = SalarioBase;
                    document.getElementById("Telefono").value = Telefono;
                    document.getElementById("FechaNacimiento").value = FechaNacimiento;
                    document.getElementById("FechaIngreso").value = FechaIngreso;
                    document.getElementById("FechaRetiro").value = FechaRetiro;
                    document.getElementById("Profesion").value = Profesion;
                    document.getElementById("Dpi").value = Dpi;
                    document.getElementById("Nit").value = Nit;
                    document.getElementById("Irtra").value = Irtra;
                    document.getElementById("Igss").value = Igss;
                    document.getElementById("Estado").value = Estado;
                    document.getElementById("Departamento").value = CodigoDepartamento;

                });
            });

            var editButtons = document.querySelectorAll(".delete-button-empleado");
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {

                    let CodigoEmpleado = button.getAttribute("data-codigo-empleado");
                    let NombreEmpleado = button.getAttribute("data-nombres-empleado");
                    let ApellidosEmpleado = button.getAttribute("data-apellidos-empleado");

                    // Rellena los campos del modal con los datos obtenidos
                    let eliminarModalNombre = document.getElementById("NombreEliminarEmpleado");
                    eliminarModalNombre.innerHTML = NombreEmpleado + " " + ApellidosEmpleado;
                    let codigoEliminar = document.getElementById('CodigoEliminarEmpleado');
                    codigoEliminar.innerHTML = CodigoEmpleado;
                });
            });

        } else {
            console.log("Error");
        }
    };

    xhr.send();
}

function btnNuevoEmpleado() {
    limpiarCamposEmpleadoModal();
    limpiarSelect('Departamento');
    document.getElementById('btnGuardarEmpleado').removeAttribute('hidden');
    let titulo = document.getElementById("tituloModalEmpleado");
    titulo.innerHTML = "Nuevo Empleado";

    document.getElementById("CodigoEmpleado").value = "";
}

function eliminarUsuario() {
    let CodigoEmpleado = document.getElementById('codigoEliminarEmpleado').textContent;

    let datos = {
        codigoEmpleado: CodigoEmpleado,
        option: 3
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/empleado-controller.php", true);
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

                    restablecerAlertas("Usuario");
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

                    restablecerAlertas("Usuario");
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

    restablecerAlertas("Usuario");
    limpiarCamposUsuarioModal();
    document.getElementById('btnGuardarUsuario').removeAttribute('hidden');
    document.getElementById('alertaCompletarCamposUsuario').setAttribute('hidden', true);
    let titulo = document.getElementById("tituloModalUsuario");
    titulo.innerHTML = "Nuevo Usuario";

    let labelClaveEditar = document.getElementById("lblClave");
    labelClaveEditar.innerHTML = "Clave";
    document.getElementById("CodigoEmpleado").value = "";
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
                cargarUsuarios();
                limpiarCamposUsuarioModal();
                alertasExitoGuardar("Usuario");
            } else {
                alertasErrorGuardar("Usuario");
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
            alertasExitoEliminar("Usuario");
        } else {
            alertasErrorElimar("Usuario");
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
                    limpiarSelect(selectId);
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
                            '<button type="button" class="btn btn-success btn-sm ms-1 edit-button-rol" data-bs-toggle="modal" data-bs-target="#modalRol" data-codigo-rol="' + rol.CodigoRol +
                            '" data-nombre-rol="' + rol.Nombre + '" data-gestiona-nomina="' + rol.GestionaNomina + '" data-gestiona-empleados="' + rol.GestionaEmpleados +
                            '" data-gestiona-menu="' + rol.GestionaMenu + '" data-gestiona-reportes="' + rol.GestionaReportes + '" data-gestiona-caja="' + rol.GestionaCaja + '" data-asistencia="' + rol.Asistencia + '">' +
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

                        restablecerAlertas("Rol");
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

                        restablecerAlertas("Rol");
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

function limpiarSelect(selectId) {

    var select = document.getElementById(selectId);
    while (select.options.length > 0) {
        select.remove(0);
    }
}

function btnNuevoRol() {

    limpiarCamposModalRol();
    restablecerAlertas("Rol");
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
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.status === 200) {
            cargarRoles();
            alertasExitoGuardar("Rol");
        } else {
            alertasErrorGuardar("Rol");
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
            alertasExitoEliminar("Rol");
        } else {
            alertasErrorElimar("Rol");
        }
    };
    xhr.send(JSON.stringify(datos));
}

function limpiarCamposEmpleadoModal() {
    CodigoEmpleado = "";
    document.getElementById("NombresEmpleado").value = "";
    document.getElementById("ApellidosEmpleado").value = "";
    document.getElementById("EmailEmpleado").value = "";
    document.getElementById("SalarioBase").value = "";
    document.getElementById("Telefono").value = "";
    document.getElementById("FechaNacimiento").value = "";
    document.getElementById("FechaIngreso").value = "";
    document.getElementById("FechaRetiro").value = "";
    document.getElementById("Profesion").value = "";
    document.getElementById("Dpi").value = "";
    document.getElementById("Nit").value = "";
    document.getElementById("Irtra").value = "";
    document.getElementById("Igss").value = "";
    document.getElementById("Estado").value = "";
    document.getElementById("Departamento").value = "";
}

function limpiarCamposUsuarioModal() {
    document.getElementById('codigoUsuario').value = "";
    document.getElementById('emailUsuario').value = "";
    document.getElementById('claveUsuario').value = "";
    document.getElementById('alertaCompletarCamposUsuario').setAttribute('hidden', true);
    var selectElement = document.getElementById('selectUsuarioRol');

    if (selectElement.options.length > 0) {
        selectElement.value = selectElement.options[0].value;
    }
}

function limpiarCamposModalRol() {
    document.getElementById("nombreRol").value = "";
    document.getElementById("gestionaNomina").checked = 0;
    document.getElementById("gestionaEmpleados").checked = 0;
    document.getElementById("gestionaMenu").checked = 0;
    document.getElementById("gestionaReportes").checked = 0;
    document.getElementById("gestionaCaja").checked = 0;
    document.getElementById("asistencia").checked = 0;
}

function restablecerAlertas(section) {
    document.getElementById('btnGuardar'+section).removeAttribute('hidden');
    document.getElementById('cancelarEliminar'+section).removeAttribute('hidden');
    document.getElementById('confirmarEliminar'+section).removeAttribute('hidden');
    document.getElementById('lblErrorEliminar'+section).setAttribute('hidden', true);
    document.getElementById('lblExitoEliminar'+section).setAttribute('hidden', true);
    document.getElementById('alertaExito'+section).setAttribute('hidden', true);
    document.getElementById('alertaError'+section).setAttribute('hidden', true);
}

function alertasExitoGuardar(section) {
    document.getElementById('btnGuardar'+section).setAttribute('hidden', true);
    document.getElementById('alertaExito'+section).removeAttribute('hidden');
    document.getElementById('alertaError'+section).setAttribute('hidden', true);
}

function alertasErrorGuardar(section) {
    document.getElementById('alertaExito'+section).setAttribute('hidden', true);
    document.getElementById('alertaError'+section).removeAttribute('hidden');
}

function alertasExitoEliminar(section){
    console.log(section);
    document.getElementById('cancelarEliminar'+section).setAttribute('hidden', true);
    document.getElementById('confirmarEliminar'+section).setAttribute('hidden', true);
    document.getElementById('lblErrorEliminar'+section).setAttribute('hidden', true);
    document.getElementById('lblExitoEliminar'+section).removeAttribute('hidden');
}

function alertasErrorElimar(section){
    document.getElementById('lblErrorEliminar'+section).removeAttribute('hidden');
    document.getElementById('lblExitoEliminar'+section).setAttribute('hidden', true);
}