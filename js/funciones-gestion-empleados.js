(function () {

    cargarUsuarios("");
    cargarRoles();
    cargarEmpleados("");
    cargarDepartamentos();
    cargarComisiones();

})();

function cargarEmpleados(busqueda) {

    let selectIds

    if(busqueda === ""){
        selectIds = ["selectDepartamentoJefe", , "tablaEmpleados"];
    }else{
        selectIds = ["tablaEmpleados"];
    }
    
    let estado = document.getElementById('estadoBusqueda').value;

    selectIds.forEach(function (selectId) {
        var xhr = new XMLHttpRequest();
        var url = "../controllers/empleado-controller.php?option=" + encodeURIComponent(1) + "&busqueda=" + encodeURIComponent(busqueda)+"&estado="+encodeURIComponent(estado);
        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                if (selectId === "selectDepartamentoJefe" && busqueda === "") {
                    limpiarSelect(selectId);
                    var select = document.getElementById(selectId);

                    data.forEach(function (empleado) {
                        var option = document.createElement("option");
                        option.value = empleado.CodigoEmpleado;
                        option.text = empleado.NombreCompleto;
                        select.appendChild(option);
                    });
                } else if (selectId === "tablaEmpleados" && data.length > 0) {
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
                            'data-codigo-empleado="' + empleado.CodigoEmpleado + '" data-nombres="' + empleado.Nombres + '" data-apellidos="' + empleado.Apellidos + '" data-email="' + empleado.Email + '" data-telefono="' + empleado.Telefono + '" data-salario="' + empleado.SalarioBase +
                            '" data-fecha-nacimiento="' + empleado.FechaNacimiento + '" data-fecha-ingreso="' + empleado.FechaIngreso + '" data-fecha-retiro="' + empleado.FechaRetiro + '" data-jornada="' + empleado.Jornada +
                            '" data-profesion="' + empleado.Profesion + '" data-dpi="' + empleado.DPI + '" data-nit="' + empleado.NIT + '" data-irtra="' + empleado.IRTRA + '" data-igss="' + empleado.IGSS +
                            '" data-estado="' + empleado.Estado + '" data-codigo-departamento="' + empleado.CodigoDepartamento + '" data-codigo-usuario-sistema="' + empleado.CodigoUsuarioSistema + '">' +
                            '<i class="fas fa-edit"></i>' +
                            '</button>' +
                            '<a href="../templates/reporte-empleado.php?CodigoEmpleado=' + empleado.CodigoEmpleado + '" target="_blank" class="btn btn-secondary btn-sm ms-1">' +
                            '<i class="fas fa-print"></i>' +
                            '</a>' +
                            '</td>';
                    });

                    var editButtons = document.querySelectorAll(".edit-button-empleado");
                    editButtons.forEach(function (button) {
                        button.addEventListener("click", function () {

                            restablecerAlertasEmpleado();
                            // Obtén los datos personalizados del botón
                            let titulo = document.getElementById("tituloModalEmpleado");
                            titulo.innerHTML = "Editar Empleados";

                            let CodigoEmpleado = button.getAttribute("data-codigo-empleado");
                            let NombresEmpleado = button.getAttribute("data-nombres");
                            let ApellidosEmpleado = button.getAttribute("data-apellidos");
                            let EmailEmpleado = button.getAttribute("data-email");
                            let Telefono = button.getAttribute("data-telefono");
                            let SalarioBase = button.getAttribute("data-salario");
                            let FechaNacimiento = button.getAttribute("data-fecha-nacimiento");
                            let FechaIngreso = button.getAttribute("data-fecha-ingreso");
                            let FechaRetiro = button.getAttribute("data-fecha-retiro");
                            let Profesion = button.getAttribute("data-profesion");
                            let Jornada = button.getAttribute("data-jornada");
                            let Dpi = button.getAttribute("data-dpi");
                            let Nit = button.getAttribute("data-nit");
                            let Irtra = button.getAttribute("data-irtra");
                            let Igss = button.getAttribute("data-igss");
                            let Estado = button.getAttribute("data-estado");
                            let CodigoDepartamento = button.getAttribute("data-codigo-departamento");
                            let CodigoUsuarioSistema = button.getAttribute("data-codigo-usuario-sistema");
                            let FormularioEmpleado = document.getElementById('formEmpleado');

                            // Rellena los campos del modal con los datos obtenidos
                            FormularioEmpleado.CodigoEmpleado.value = CodigoEmpleado;
                            FormularioEmpleado.NombresEmpleado.value = NombresEmpleado;
                            FormularioEmpleado.ApellidosEmpleado.value = ApellidosEmpleado;
                            FormularioEmpleado.EmailEmpleado.value = EmailEmpleado;
                            FormularioEmpleado.SalarioBase.value = SalarioBase;
                            FormularioEmpleado.Telefono.value = Telefono;
                            FormularioEmpleado.FechaNacimiento.value = FechaNacimiento;
                            FormularioEmpleado.FechaIngreso.value = FechaIngreso;
                            FormularioEmpleado.FechaRetiro.value = FechaRetiro;
                            FormularioEmpleado.Profesion.value = Profesion;
                            FormularioEmpleado.Jornada.value = Jornada;
                            FormularioEmpleado.Dpi.value = Dpi;
                            FormularioEmpleado.Nit.value = Nit;
                            FormularioEmpleado.Irtra.value = Irtra;
                            FormularioEmpleado.Igss.value = Igss;
                            FormularioEmpleado.Estado.value = Estado;
                            FormularioEmpleado.SelectEmpleadoDepartamento.value = CodigoDepartamento;
                            FormularioEmpleado.SelectEmpleadoUsuarioSistema.value = CodigoUsuarioSistema;
                        });
                    });
                }
            } else {
                console.log("Error");
            }
        };

        xhr.send();
    });
}

function btnNuevoEmpleado() {
    restablecerAlertasEmpleado();
    limpiarCamposEmpleadoModal();
    document.getElementById('btnGuardarEmpleado').removeAttribute('hidden');
    let titulo = document.getElementById("tituloModalEmpleado");
    titulo.innerHTML = "Nuevo Empleado";

    document.getElementById("CodigoEmpleado").value = "";
}

function buscarEmpleado() {
    let busquedaEmpleado = document.getElementById('empleadoBusqueda').value;
    cargarEmpleados(busquedaEmpleado);
}

function guardarEmpleado() {
    let FormularioEmpleado = document.getElementById('formEmpleado');

    let campos = [
        'NombresEmpleado',
        'ApellidosEmpleado',
        'EmailEmpleado',
        'Telefono',
        'SalarioBase',
        'FechaNacimiento',
        'FechaIngreso',
        'Profesion',
        'Dpi',
        'Estado',
        'SelectEmpleadoDepartamento',
        'SelectEmpleadoUsuarioSistema'
    ];

    let todosCamposValidos = true;

    for (let campo of campos) {
        let valor = FormularioEmpleado[campo].value;
        if (valor === '') {
            todosCamposValidos = false;
            break;
        }
    }

    if (!todosCamposValidos) {
        document.getElementById('alertaCompletarCamposEmpleado').removeAttribute('hidden');
    } else {
        let option = 0;
        if (FormularioEmpleado.CodigoEmpleado.value === "") {
            option = 1;
        } else {
            option = 2;
        }

        let datos = {
            CodigoEmpleado: FormularioEmpleado.CodigoEmpleado.value,
            NombresEmpleado: FormularioEmpleado.NombresEmpleado.value,
            ApellidosEmpleado: FormularioEmpleado.ApellidosEmpleado.value,
            EmailEmpleado: FormularioEmpleado.EmailEmpleado.value,
            Telefono: FormularioEmpleado.Telefono.value,
            SalarioBase: FormularioEmpleado.SalarioBase.value,
            FechaNacimiento: FormularioEmpleado.FechaNacimiento.value,
            FechaIngreso: FormularioEmpleado.FechaIngreso.value,
            FechaRetiro: FormularioEmpleado.FechaRetiro.value,
            Profesion: FormularioEmpleado.Profesion.value,
            Fotografia: "",
            Jornada: FormularioEmpleado.Jornada.value,
            Dpi: FormularioEmpleado.Dpi.value,
            Nit: FormularioEmpleado.Nit.value,
            Irtra: FormularioEmpleado.Irtra.value,
            Igss: FormularioEmpleado.Igss.value,
            Estado: FormularioEmpleado.Estado.value,
            CodigoDepartamento: FormularioEmpleado.SelectEmpleadoDepartamento.value,
            CodigoUsuarioSistema: FormularioEmpleado.SelectEmpleadoUsuarioSistema.value,
            option: option
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/empleado-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('alertaCompletarCamposEmpleado').setAttribute('hidden', true);
                cargarEmpleados("");
                limpiarCamposEmpleadoModal();
                alertasExitoGuardar("Empleado");
                (async function iniciarPausa() {
                    await pausarPorSegundosAsync(2);
                    window.location.reload();
                })();
            } else if (xhr.status === 409) {
                alertaDuplicado("Empleado");
            } else if (xhr.status === 400) {
                alertaNoAfectacion("Empleado");
            } else {
                alertasErrorGuardar("Empleado");
            }
        };
        xhr.send(JSON.stringify(datos));
    }
}

function cargarDepartamentos() {

    let selectIds = ["SelectEmpleadoDepartamento", "tablaDepartamentos"];

    selectIds.forEach(function (selectId) {
        var xhr = new XMLHttpRequest();
        var url = "../controllers/departamento-controller.php?option=" + encodeURIComponent(1);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                if (selectId === "SelectEmpleadoDepartamento") {
                    limpiarSelect(selectId);
                    var select = document.getElementById(selectId);

                    data.forEach(function (departamento) {
                        var option = document.createElement("option");
                        option.value = departamento.CodigoDepartamento;
                        option.text = departamento.NombreDepartamento;
                        select.appendChild(option);
                    });
                } else if (selectId === "tablaDepartamentos") {

                    borrarContenidoTabla("tablaDepartamentos");
                    var tabla = document.getElementById("tablaDepartamentos").getElementsByTagName("tbody")[0];

                    data.forEach(function (departamento) {
                        var row = tabla.insertRow();
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        cell1.innerHTML = departamento.CodigoDepartamento;
                        cell2.innerHTML = departamento.NombreDepartamento;
                        cell3.innerHTML = departamento.NombreComision;
                        cell4.innerHTML = departamento.NombreJefe;
                        cell5.innerHTML = '<td>' +
                            '<button type="button" class="btn btn-success btn-sm ms-1 edit-button-departamento" data-bs-toggle="modal" data-bs-target="#departamentoModal" data-codigo-departamento="' + departamento.CodigoDepartamento + '" data-nombre-departamento="' + departamento.NombreDepartamento + '" data-codigo-comision="' + departamento.CodigoComision + '" data-codigo-empleado="' + departamento.CodigoEmpleado + '">' +
                            '<i class="fas fa-edit"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button-departamento" data-bs-toggle="modal" data-bs-target="#eliminarDepartamentoModal" data-codigo-departamento="' + departamento.CodigoDepartamento + '" data-nombre-departamento="' + departamento.NombreDepartamento + '">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</td>';
                    });

                    var editButtons = document.querySelectorAll(".edit-button-departamento");
                    editButtons.forEach(function (button) {
                        button.addEventListener("click", function () {
                            let FormularioDepartamento = document.getElementById('formDepartamento');
                            restablecerAlertas("Departamento");
                            // Obtén los datos personalizados del botón
                            let titulo = document.getElementById("tituloModalDepartamento");
                            titulo.innerHTML = "Editar Departamento";

                            var CodigoDepartamento = button.getAttribute("data-codigo-departamento");
                            var NombreDepartamento = button.getAttribute("data-nombre-departamento");
                            var CodigoComision = button.getAttribute("data-codigo-comision");
                            var CodigoEmpleado = button.getAttribute("data-codigo-empleado");

                            // Rellena los campos del modal con los datos obtenidos
                            FormularioDepartamento.codigoDepartamento.value = CodigoDepartamento;
                            FormularioDepartamento.nombreDepartamento.value = NombreDepartamento;
                            FormularioDepartamento.selectDepartamentoComision.value = CodigoComision;
                            FormularioDepartamento.selectDepartamentoJefe.value = CodigoEmpleado;
                        });
                    });

                    var editButtons = document.querySelectorAll(".delete-button-departamento");
                    editButtons.forEach(function (button) {
                        button.addEventListener("click", function () {

                            restablecerAlertas("Departamento");
                            let CodigoDepartamento = button.getAttribute("data-codigo-departamento");
                            let NombreDepartamento = button.getAttribute("data-nombre-departamento");

                            // Rellena los campos del modal con los datos obtenidos
                            let descripcionNombreDepartamento = document.getElementById("descripcionEliminarDepartamento");
                            descripcionNombreDepartamento.innerHTML = NombreDepartamento;
                            let codigoEliminarDepartamento = document.getElementById('codigoEliminarDepartamento');
                            codigoEliminarDepartamento.innerHTML = CodigoDepartamento;
                        });
                    });
                }

            } else {
                console.log("Error");
            }
        };

        xhr.send();
    });
}

function btnNuevoDepartamento() {
    restablecerAlertas("Departamento");
    limpiarCamposDepartamentoModal();
    document.getElementById('btnGuardarDepartamento').removeAttribute('hidden');
    document.getElementById('alertaCompletarCamposDepartamento').setAttribute('hidden', true);
    let titulo = document.getElementById("tituloModalDepartamento");
    titulo.innerHTML = "Nuevo Departamento";
}

function guardarDepartamento() {
    let FormularioDepartamento = document.getElementById('formDepartamento');
    let codigoDepartamento = FormularioDepartamento.codigoDepartamento.value;
    let nombreDepartamento = FormularioDepartamento.nombreDepartamento.value;
    let codigoComision = FormularioDepartamento.selectDepartamentoComision.value;
    let codigoJefe = FormularioDepartamento.selectDepartamentoJefe.value;

    if (nombreDepartamento === "") {
        document.getElementById('alertaCompletarCamposDepartamento').removeAttribute('hidden');
    } else {
        let option = 0;
        if (codigoDepartamento === "") {
            option = 1;
        } else {
            option = 2;
        }

        console.log(option);

        let datos = {
            codigoDepartamento: codigoDepartamento,
            nombreDepartamento: nombreDepartamento,
            codigoComision: codigoComision,
            codigoJefe: codigoJefe,
            option: option
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/departamento-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('alertaCompletarCamposDepartamento').setAttribute('hidden', true);
                cargarDepartamentos();
                limpiarCamposDepartamentoModal();
                alertasExitoGuardar("Departamento");
            } else if (xhr.status === 409) {
                alertaDuplicado("Departamento");
            } else if (xhr.status === 400) {
                alertaNoAfectacion("Departamento");
            } else {
                alertasErrorGuardar("Departamento");
            }
        };

        xhr.send(JSON.stringify(datos));
    }
}

function eliminarDepartamento() {
    var codigoDepartamento = document.getElementById('codigoEliminarDepartamento').textContent;
    let datos = {
        codigoDepartamento: codigoDepartamento,
        option: 3
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/departamento-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarDepartamentos();
            alertasExitoEliminar("Departamento");
        } else {
            alertasErrorElimar("Departamento");
        }
    };
    xhr.send(JSON.stringify(datos));
}

function cargarComisiones() {

    let selectIds = ["selectDepartamentoComision", "tablaComisiones"];

    selectIds.forEach(function (selectId) {
        var xhr = new XMLHttpRequest();
        var url = "../controllers/departamento-controller.php?option=" + encodeURIComponent(2);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                if (selectId === "selectDepartamentoComision") {
                    limpiarSelect(selectId);
                    var select = document.getElementById(selectId);

                    data.forEach(function (comision) {
                        var option = document.createElement("option");
                        option.value = comision.CodigoComision;
                        option.text = comision.Nombre;
                        select.appendChild(option);
                    });
                } else if (selectId === "tablaComisiones") {
                    let tabla = document.getElementById("tablaComisiones").getElementsByTagName("tbody")[0];

                    borrarContenidoTabla("tablaComisiones");

                    data.forEach(function (comision) {
                        var row = tabla.insertRow();
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);

                        cell1.innerHTML = comision.CodigoComision;
                        cell2.innerHTML = comision.Nombre;
                        cell3.innerHTML = comision.Restricciones;
                        cell4.innerHTML = comision.Bono;
                        cell5.innerHTML = '<td>' +
                            '<button type="button" class="btn btn-success btn-sm ms-1 edit-button-comision" data-bs-toggle="modal" data-bs-target="#modalComision" data-codigo-comision="' + comision.CodigoComision + '" data-nombre-comision="' + comision.Nombre + '" data-restricciones-comision="' + comision.Restricciones + '" data-bono-comision="' + comision.Bono + '">' +
                            '<i class="fas fa-edit"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button-comision" data-bs-toggle="modal" data-bs-target="#eliminarComision" data-codigo-comision="' + comision.CodigoComision + '" data-nombre-comision="' + comision.Nombre + '">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</td>';
                    });

                    var editButtons = document.querySelectorAll(".edit-button-comision");
                    editButtons.forEach(function (button) {
                        button.addEventListener("click", function () {

                            restablecerAlertas("Comision");
                            document.getElementById('btnGuardarComision').removeAttribute('hidden');
                            // Obtén los datos personalizados del botón
                            let titulo = document.getElementById("tituloModalComision");
                            titulo.innerHTML = "Editar Comisión";

                            let codigoComision = button.getAttribute("data-codigo-comision");
                            let nombreComision = button.getAttribute("data-nombre-comision");
                            let restriccionesComision = button.getAttribute("data-restricciones-comision");
                            let bonoComision = button.getAttribute("data-bono-comision");

                            // Rellena los campos del modal con los datos obtenidos
                            document.getElementById('codigoComision').value = codigoComision;
                            document.getElementById("nombreComision").value = nombreComision;
                            document.getElementById("restriccionesComision").value = restriccionesComision;
                            document.getElementById("bonoComision").value = bonoComision;
                        });
                    });

                    var editButtons = document.querySelectorAll(".delete-button-comision");
                    editButtons.forEach(function (button) {
                        button.addEventListener("click", function () {

                            restablecerAlertas("Rol");
                            let codigoComision = button.getAttribute("data-codigo-comision");
                            let nombreComision = button.getAttribute("data-nombre-comision");

                            // Rellena los campos del modal con los datos obtenidos
                            let eliminarModalDescripcion = document.getElementById("descripcionEliminarComision");
                            eliminarModalDescripcion.innerHTML = nombreComision;
                            let codigoEliminarComision = document.getElementById('codigoEliminarComision');
                            codigoEliminarComision.innerHTML = codigoComision;
                        });
                    });
                }

            } else {
                console.log("Error");
            }
        };

        xhr.send();
    });
}

function btnNuevaComision() {
    restablecerAlertas("Comision");
    limpiarCamposComision();
    document.getElementById('btnGuardarComision').removeAttribute('hidden');
    let titulo = document.getElementById("tituloModalComision");
    titulo.innerHTML = "Nueva Comision";

    document.getElementById("codigoComision").value = "";
}

function guardarComision() {
    let FormularioDepartamento = document.getElementById('formComision');
    let codigoComision = FormularioDepartamento.codigoComision.value;
    let nombreComision = FormularioDepartamento.nombreComision.value;
    let restriccionesComision = FormularioDepartamento.restriccionesComision.value;
    let bonoComision = FormularioDepartamento.bonoComision.value;

    if (nombreComision === "", codigoComision === "", restriccionesComision === "", bonoComision === "") {
        document.getElementById('alertaCompletarCamposComision').removeAttribute('hidden');
    } else {
        let option = 0;
        if (codigoComision === "") {
            option = 4;
        } else {
            option = 5;
        }

        let datos = {
            codigoComision: codigoComision,
            nombreComision: nombreComision,
            restriccionesComision: restriccionesComision,
            bonoComision: bonoComision,
            option: option
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/departamento-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('alertaCompletarCamposComision').setAttribute('hidden', true);
                cargarComisiones();
                limpiarCamposComision();
                alertasExitoGuardar("Comision");
            } else if (xhr.status === 409) {
                alertaDuplicado("Comision");
            } else if (xhr.status === 400) {
                alertaNoAfectacion("Comision");
            } else {
                alertasErrorGuardar("Comision");
            }
        };

        xhr.send(JSON.stringify(datos));
    }
}

function eliminarComision() {
    var codigoComision = document.getElementById('codigoEliminarComision').textContent;
    let datos = {
        codigoComision: codigoComision,
        option: 6
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/departamento-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarComisiones();
            alertasExitoEliminar("Comision");
        } else {
            alertasErrorElimar("Comision");
        }
    };
    xhr.send(JSON.stringify(datos));
}

function cargarUsuarios(busqueda) {

    let selectIds;
    if(busqueda === ""){
        selectIds = ["SelectEmpleadoUsuarioSistema", "tablaUsuarios"];
    }else{
        selectIds = ["tablaUsuarios"];
    }
    

    selectIds.forEach(function (selectId) {

        var xhr = new XMLHttpRequest();

        var url = "../controllers/usuario-controller.php?option=" + encodeURIComponent(1) + "&busqueda=" + encodeURIComponent(busqueda);
        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                if (selectId === "SelectEmpleadoUsuarioSistema" && busqueda === "") {
                    limpiarSelect(selectId);
                    var select = document.getElementById(selectId);

                    data.forEach(function (usuario) {
                        var option = document.createElement("option");
                        option.value = usuario.Codigo;
                        option.text = usuario.Email;
                        select.appendChild(option);
                    });
                } else if (selectId === "tablaUsuarios" && data.length > 0) {
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
                            '<button type="button" class="btn btn-danger btn-sm ms-1 delete-button-usuario" data-bs-toggle="modal" data-bs-target="#eliminarUsuario" data-codigo-usuario="' + usuario.Codigo + '" data-email="' + usuario.Email + '">' +
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
                }
            } else {
                console.log(xhr.responseText);
            }
        };

        xhr.send();
    });
}

function buscarUsuario() {
    let busquedaUsuario = document.getElementById('usuarioBusqueda').value;
    cargarUsuarios(busquedaUsuario);
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
        document.getElementById('alertaCompletarCamposUsuario').removeAttribute('hidden');
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
                document.getElementById('alertaCompletarCamposUsuario').setAttribute('hidden', true);
                cargarUsuarios("");
                limpiarCamposUsuarioModal();
                alertasExitoGuardar("Usuario");
            } else if (xhr.status === 409) {
                alertaDuplicado("Usuario");
            } else if (xhr.status === 400) {
                alertaNoAfectacion("Usuario");
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
            cargarUsuarios("");
            alertasExitoEliminar("Usuario");
        } else {
            alertasErrorElimar("Usuario");
        }
    };
    xhr.send(JSON.stringify(datos));
}

function cargarRoles() {

    let selectIds = ["selectUsuarioRol", "tablaRoles"];

    selectIds.forEach(function (selectId) {
        var xhr = new XMLHttpRequest();
        var url = "../controllers/usuario-controller.php?option=" + encodeURIComponent(2);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                if (selectId === "selectUsuarioRol") {
                    limpiarSelect(selectId);
                    var select = document.getElementById(selectId);

                    data.forEach(function (rol) {
                        var option = document.createElement("option");
                        option.value = rol.CodigoRol;
                        option.text = rol.Nombre;
                        select.appendChild(option);
                    });
                } else if (selectId === "tablaRoles") {
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
                }

            } else {
                console.log("Error");
            }
        };

        xhr.send();
    });
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

    if (nombreRol === "") {
        document.getElementById('alertaCompletarCamposRol').removeAttribute('hidden');
    } else {
        checkboxes.forEach(function (checkbox) {
            checkbox.value = checkbox.checked ? 1 : 0;
        });

        var permisosArray = Array.from(checkboxes, function (checkbox) {
            return checkbox.value;
        });

        if (codigoRolHidden === "" || nombreRol === "") {

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
                document.getElementById('alertaCompletarCamposRol').setAttribute('hidden', true);
                cargarRoles();
                alertasExitoGuardar("Rol");
                limpiarCamposModalRol();
            } else if (xhr.status === 409) {
                alertaDuplicado("Rol");
            } else if (xhr.status === 400) {
                alertaNoAfectacion("Rol");
            } else {
                alertasErrorGuardar("Rol");
            }
        };

        // Enviamos los datos al formulario
        xhr.send(JSON.stringify(datos));
    }
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

function limpiarSelect(selectId) {

    var select = document.getElementById(selectId);
    while (select.options.length > 1) {
        select.remove(1);
    }
}

function limpiarCamposEmpleadoModal() {
    let FormularioEmpleado = document.getElementById('formEmpleado');
    FormularioEmpleado.reset();
}

function limpiarCamposComision() {
    let FormularioComision = document.getElementById('formComision');
    FormularioComision.reset();
}

function limpiarCamposUsuarioModal() {
    let FormularioUsuario = document.getElementById('formUsuario');
    FormularioUsuario.reset();

    document.getElementById('alertaCompletarCamposUsuario').setAttribute('hidden', true);
    var selectElement = document.getElementById('selectUsuarioRol');

    if (selectElement.options.length > 0) {
        selectElement.value = selectElement.options[0].value;
    }
}

function borrarContenidoTabla(nombreTabla) {
    var tabla = document.getElementById("" + nombreTabla + "");
    var tbody = tabla.getElementsByTagName("tbody")[0];

    // Borra todas las filas del cuerpo de la tabla
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
}

function limpiarCamposModalRol() {
    let FormularioRol = document.getElementById('formRol');
    FormularioRol.reset();
}

function limpiarCamposDepartamentoModal() {
    let FormularioDepartamento = document.getElementById("formDepartamento");
    FormularioDepartamento.reset();
}

function restablecerAlertas(section) {
    document.getElementById('btnGuardar' + section).removeAttribute('hidden');
    document.getElementById('cancelarEliminar' + section).removeAttribute('hidden');
    document.getElementById('confirmarEliminar' + section).removeAttribute('hidden');
    document.getElementById('lblErrorEliminar' + section).setAttribute('hidden', true);
    document.getElementById('lblExitoEliminar' + section).setAttribute('hidden', true);
    document.getElementById('alertaExito' + section).setAttribute('hidden', true);
    document.getElementById('alertaError' + section).setAttribute('hidden', true);
    document.getElementById('alertaDuplicado' + section).setAttribute('hidden', true);
    document.getElementById('alertaNoAfectacion' + section).setAttribute('hidden', true);
    document.getElementById('alertaCompletarCampos' + section).setAttribute('hidden', true);
}

function restablecerAlertasEmpleado() {
    document.getElementById('btnGuardarEmpleado').removeAttribute('hidden');
    document.getElementById('alertaExitoEmpleado').setAttribute('hidden', true);
    document.getElementById('alertaErrorEmpleado').setAttribute('hidden', true);
    document.getElementById('alertaDuplicadoEmpleado').setAttribute('hidden', true);
    document.getElementById('alertaNoAfectacionEmpleado').setAttribute('hidden', true);
    document.getElementById('alertaCompletarCamposEmpleado').setAttribute('hidden', true);
}

function alertasExitoGuardar(section) {
    document.getElementById('alertaExito' + section).removeAttribute('hidden');
    document.getElementById('alertaError' + section).setAttribute('hidden', true);
    document.getElementById('alertaDuplicado' + section).setAttribute('hidden', true);
    document.getElementById('alertaNoAfectacion' + section).setAttribute('hidden', true);
    document.getElementById('btnGuardar' + section).setAttribute('hidden', true);
}

function alertasErrorGuardar(section) {
    document.getElementById('alertaExito' + section).setAttribute('hidden', true);
    document.getElementById('alertaError' + section).removeAttribute('hidden');
    document.getElementById('alertaDuplicado' + section).setAttribute('hidden', true);
}

function alertaNoAfectacion(section) {
    document.getElementById('alertaNoAfectacion' + section).removeAttribute('hidden');
}

function alertasExitoEliminar(section) {
    document.getElementById('cancelarEliminar' + section).setAttribute('hidden', true);
    document.getElementById('confirmarEliminar' + section).setAttribute('hidden', true);
    document.getElementById('lblErrorEliminar' + section).setAttribute('hidden', true);
    document.getElementById('lblExitoEliminar' + section).removeAttribute('hidden');
}

function alertasErrorElimar(section) {
    document.getElementById('lblErrorEliminar' + section).removeAttribute('hidden');
    document.getElementById('lblExitoEliminar' + section).setAttribute('hidden', true);
}

function alertaDuplicado(section) {
    document.getElementById('alertaDuplicado' + section).removeAttribute('hidden');
    document.getElementById('alertaNoAfectacion' + section).setAttribute('hidden', true);
}

function limitarValor(input, max) {
    if (input.value.length > max) {
        input.value = 0;
    }
}

function pausarPorSegundosAsync(segundos) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve();
        }, segundos * 1000);
    });
}