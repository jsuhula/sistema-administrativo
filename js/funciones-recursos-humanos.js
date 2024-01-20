(function () {

    cargarUsuarios("");
    cargarRoles();
    cargarEmpleados("");
    cargarDepartamentos();
    cargarComisiones();

})();

function cargarEmpleados(busqueda) {
    let selectIds;

    if (busqueda === "") {
        selectIds = ["selectDepartamentoJefe", "tablaEmpleados"];
    } else {
        selectIds = ["tablaEmpleados"];
    }

    let estado = document.getElementById('estadoBusqueda').value;

    selectIds.forEach(function (selectId) {
        const xhr = new XMLHttpRequest();
        const url = `../controllers/administracion.recursos-humanos-controller.php?option=${encodeURIComponent(1)}&busqueda=${encodeURIComponent(busqueda)}&estado=${encodeURIComponent(estado)}`;
        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                if (selectId === "selectDepartamentoJefe" && busqueda === "") {
                    cargarSelectDepartamentoJefe(data);
                } else if (selectId === "tablaEmpleados" && data.length > 0) {
                    cargarTablaEmpleados(data);
                }
            }
        };

        xhr.send();
    });
}

function cargarSelectDepartamentoJefe(data) {
    const select = document.getElementById("selectDepartamentoJefe");
    limpiarSelect("selectDepartamentoJefe");

    data.forEach(function (empleado) {
        const option = document.createElement("option");
        option.value = empleado.CodigoEmpleado;
        option.text = empleado.NombreCompleto;
        select.appendChild(option);
    });
}

function cargarTablaEmpleados(data) {
    const tabla = document.getElementById("tablaEmpleados").getElementsByTagName("tbody")[0];
    borrarContenidoTabla("tablaEmpleados");

    data.forEach(function (empleado) {
        const row = tabla.insertRow();

        for (let i = 0; i < 7; i++) {
            const cell = row.insertCell(i);
            switch (i) {
                case 0:
                    cell.innerHTML = empleado.CodigoEmpleado;
                    break;
                case 1:
                    cell.innerHTML = empleado.NombreCompleto;
                    break;
                case 2:
                    cell.innerHTML = empleado.Email;
                    break;
                case 3:
                    cell.innerHTML = empleado.Departamento;
                    break;
                case 4:
                    cell.innerHTML = empleado.SalarioBase;
                    break;
                case 5:
                    cell.innerHTML = empleado.Estado === 1 ? "Activo" : "Inactivo";
                    break;
                case 6:
                    cell.innerHTML = `<td>
                        <button type="button" class="btn btn-outline-success btn-sm ms-1 edit-button-empleado" 
                            data-bs-toggle="modal" data-bs-target="#modalEmpleado" ${crearAtributosDatosEmpleado(empleado)}>
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="../templates/reporte-empleado.php?CodigoEmpleado=${empleado.CodigoEmpleado}" 
                            target="_blank" class="btn btn-outline-secondary btn-sm ms-1">
                            <i class="fas fa-print"></i>
                        </a>
                    </td>`;
                    break;
            }
        }
    });

    asignarEventosBotonesEmpleados("edit-button-empleado", "Empleado");
}

function crearAtributosDatosEmpleado(empleado) {
    return Object.keys(empleado)
        .map(key => `data-${key}="${empleado[key]}"`)
        .join(" ");
}

function asignarEventosBotonesEmpleados(editClassName, entidad) {
    const editButtons = document.querySelectorAll(`.${editClassName}`);
    editButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta('Empleado');

            let titulo = document.getElementById("tituloModal" + entidad);
            titulo.innerHTML = "Editar " + entidad;

            let datos = {};
            for (const key in button.dataset) {
                if (button.dataset.hasOwnProperty(key) && button.dataset[key] !== "undefined") {
                    datos[key] = button.dataset[key];
                }
            }

            let FormularioEmpleado = document.getElementById('formEmpleado');
            llenarFormularioEmpleado(FormularioEmpleado, datos);
        });
    });
}

function llenarFormularioEmpleado(formulario, datos) {
    const ids = obtenerIdsFormulario(formulario);
    for (const valueData of ids) {
        if (datos.hasOwnProperty(valueData.toLowerCase()) && valueData !== "foto") {
            formulario[valueData].value = datos[valueData.toLowerCase()];
        }
    }
}

function obtenerIdsFormulario(formulario) {
    let elementos = formulario.querySelectorAll('[id]');
    return Array.from(elementos, elemento => elemento.id);
}


function btnNuevoEmpleado() {
    restablecerAlerta('Empleado');
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
    const FormularioEmpleado = document.getElementById('formEmpleado');
    const campos = [
        'Nombres', 'Apellidos', 'Email', 'Telefono',
        'SalarioBase', 'FechaNacimiento', 'FechaIngreso', 'Profesion',
        'Dpi', 'Estado', 'CodigoDepartamento', 'CodigoUsuarioSistema', 'CodigoJornadaLaboral'
    ];

    const todosCamposValidos = campos.every(campo => FormularioEmpleado[campo].value.trim() !== '');

    if (!todosCamposValidos) {
        mostrarAlerta('Empleado', 'Por favor complete los campos necesarios', 'advertencia');
        return;
    }

    const option = FormularioEmpleado.CodigoEmpleado.value === "" ? 1 : 2;

    const datos = {
        CodigoEmpleado: FormularioEmpleado.CodigoEmpleado.value,
        NombresEmpleado: FormularioEmpleado.Nombres.value,
        ApellidosEmpleado: FormularioEmpleado.Apellidos.value,
        EmailEmpleado: FormularioEmpleado.Email.value,
        Telefono: FormularioEmpleado.Telefono.value,
        SalarioBase: FormularioEmpleado.SalarioBase.value,
        FechaNacimiento: FormularioEmpleado.FechaNacimiento.value,
        FechaIngreso: FormularioEmpleado.FechaIngreso.value,
        FechaRetiro: FormularioEmpleado.FechaRetiro.value,
        Profesion: FormularioEmpleado.Profesion.value,
        Fotografia: "",
        Dpi: FormularioEmpleado.Dpi.value,
        Nit: FormularioEmpleado.Nit.value,
        Irtra: FormularioEmpleado.Irtra.value,
        Igss: FormularioEmpleado.Igss.value,
        Estado: FormularioEmpleado.Estado.value,
        CodigoDepartamento: FormularioEmpleado.CodigoDepartamento.value,
        CodigoUsuarioSistema: FormularioEmpleado.CodigoUsuarioSistema.value,
        CodigoJornadaLaboral: FormularioEmpleado.CodigoJornadaLaboral.value,
        option: option
    };

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/administracion.recursos-humanos-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        switch (xhr.status) {
            case 200:
                cargarEmpleados("");
                limpiarCamposModal("formEmpleado");
                cerrarModal("modalEmpleado");
                mostrarModalExitoso("modalGuardarExitoso");
                // (async function iniciarPausa() {
                //     await pausarPorSegundosAsync(2);
                //     window.location.reload();
                // })();
                break;
            case 409:
                mostrarAlerta('Empleado', 'Ya se encuentra el registro en el sistema', 'advertencia');
                break;
            case 403:
                mostrarAlerta('Empleado', 'El usuario ya se encuentra asignado', 'info');
                break;
            case 400:
                mostrarAlerta('Empleado', 'No se realizaron cambios', 'info');
                break;
            default:
                mostrarAlerta('Empleado', 'Ocurrió un error inesperado', 'error');
                break;
        }
    };
    

    xhr.send(JSON.stringify(datos));
}

function cargarDepartamentos() {
    const selectIds = ["CodigoDepartamento", "tablaDepartamentos"];

    selectIds.forEach(async function (selectId) {
        const url = `../controllers/administracion.departamento-controller.php?option=${encodeURIComponent(1)}`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();

            if (selectId === "CodigoDepartamento") {
                limpiarSelect(selectId);
                const select = document.getElementById(selectId);

                data.forEach(function (departamento) {
                    const option = document.createElement("option");
                    option.value = departamento.CodigoDepartamento;
                    option.text = departamento.NombreDepartamento;
                    select.appendChild(option);
                });
            } else if (selectId === "tablaDepartamentos") {
                const tabla = document.getElementById("tablaDepartamentos").getElementsByTagName("tbody")[0];
                borrarContenidoTabla("tablaDepartamentos");

                data.forEach(function (departamento) {
                    const row = tabla.insertRow();
                    const cells = [departamento.CodigoDepartamento, departamento.NombreDepartamento, departamento.NombreComision, departamento.NombreJefe];

                    cells.forEach((cell, index) => {
                        const cellElement = row.insertCell(index);
                        cellElement.innerHTML = cell;
                    });

                    const cellAcciones = row.insertCell(cells.length);
                    cellAcciones.innerHTML = `
                        <td>
                            <button type="button" class="btn btn-outline-success btn-sm ms-1 edit-button-departamento"
                                data-bs-toggle="modal" data-bs-target="#departamentoModal"
                                data-codigo-departamento="${departamento.CodigoDepartamento}"
                                data-nombre-departamento="${departamento.NombreDepartamento}"
                                data-codigo-comision="${departamento.CodigoComision}"
                                data-codigo-empleado="${departamento.CodigoEmpleado || 'null'}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm ms-1 delete-button-departamento"
                                data-bs-toggle="modal" data-bs-target="#eliminarDepartamentoModal"
                                data-codigo-departamento="${departamento.CodigoDepartamento}"
                                data-nombre-departamento="${departamento.NombreDepartamento}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>`;
                });

                asignarEventosBotonesDepartamentos("edit-button-departamento", "delete-button-departamento", "Departamento");
            }
        } catch (error) {
            console.error(error);
        }
    });
}

function asignarEventosBotonesDepartamentos(editClassName, deleteClassName) {
    const editButtons = document.querySelectorAll(`.${editClassName}`);
    editButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta("Departamento");
            const titulo = document.getElementById("tituloModalDepartamento");
            titulo.innerHTML = "Editar Departamento";

            const atributosDatos = Object.fromEntries(Object.entries(button.dataset).map(([key, value]) => [key.toLowerCase(), value]));

            const formularioDepartamento = document.getElementById('formDepartamento');
            formularioDepartamento.reset();

            llenarFormularioDepartamento(formularioDepartamento, atributosDatos);
        });
    });

    const deleteButtons = document.querySelectorAll(`.${deleteClassName}`);
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta("EliminarDepartamento");

            const codigoDepartamento = button.getAttribute("data-codigo-departamento");
            const nombreDepartamento = button.getAttribute("data-nombre-departamento");

            const leyendaConfirmacionEliminar = document.getElementById("leyendaConfirmacionEliminarDepartamento");
            leyendaConfirmacionEliminar.removeAttribute("hidden");

            const descripcionEliminarDepartamento = document.getElementById("descripcionEliminarDepartamento");
            descripcionEliminarDepartamento.innerHTML = nombreDepartamento;

            const codigoEliminarDepartamento = document.getElementById('codigoEliminarDepartamento');
            codigoEliminarDepartamento.innerHTML = codigoDepartamento;
        });
    });
}

function llenarFormularioDepartamento(formulario, datos) {
    formulario.codigoDepartamento.value = datos.codigodepartamento;
    formulario.nombreDepartamento.value = datos.nombredepartamento;
    formulario.selectDepartamentoComision.value = datos.codigocomision;

    if (datos.codigoempleado !== 'null') {
        formulario.selectDepartamentoJefe.value = datos.codigoempleado;
    }
}

function btnNuevoDepartamento() {
    restablecerAlerta("Departamento");
    limpiarCamposModal("formDepartamento");
    document.getElementById('btnGuardarDepartamento').removeAttribute('hidden');
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
        mostrarAlerta('Departamento', 'Por favor complete los campos necesarios', 'advertencia');
    } else {

        const option = codigoDepartamento === "" ? 1 : 2;

        let datos = {
            codigoDepartamento: codigoDepartamento,
            nombreDepartamento: nombreDepartamento,
            codigoComision: codigoComision,
            codigoJefe: codigoJefe,
            option: option
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/administracion.departamento-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            switch (xhr.status) {
                case 200:
                    cargarDepartamentos();
                    limpiarCamposModal("formDepartamento");
                    cerrarModal("departamentoModal");
                    mostrarModalExitoso("modalGuardarExitoso");
                    break;
                case 409:
                    mostrarAlerta('Departamento', 'Ya se encuentra el registro en el sistema', 'advertencia');
                    break;
                case 400:
                    mostrarAlerta('Departamento', 'No se realizaron cambios', 'info');
                    break;
                default:
                    mostrarAlerta('Departamento', 'Ocurrió un error inesperado', 'error');
                    break;
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
    xhr.open("POST", "../controllers/administracion.departamento-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarDepartamentos();
            cerrarModal('eliminarDepartamentoModal');
            mostrarModalExitoso("modalEliminacionExitosa");
        } else {
            mostrarAlerta('EliminarDepartamento', 'Ocurrio un error inesperado', 'error')
        }
    };
    xhr.send(JSON.stringify(datos));
}

function cargarComisiones() {
    const selectIds = ["selectDepartamentoComision", "tablaComisiones"];

    selectIds.forEach(function (selectId) {
        const xhr = new XMLHttpRequest();
        const url = `../controllers/administracion.departamento-controller.php?option=${encodeURIComponent(2)}`;

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                if (selectId === "selectDepartamentoComision") {
                    cargarOpcionesComision(selectId, data);
                } else if (selectId === "tablaComisiones") {
                    cargarTablaComisiones(data);
                }
            }
        };

        xhr.send();
    });
}

function cargarOpcionesComision(selectId, data) {
    const select = document.getElementById(selectId);
    limpiarSelect(selectId);

    data.forEach(function (comision) {
        const option = document.createElement("option");
        option.value = comision.CodigoComision;
        option.text = comision.Nombre;
        select.appendChild(option);
    });
}

function cargarTablaComisiones(data) {
    const tabla = document.getElementById("tablaComisiones").getElementsByTagName("tbody")[0];
    borrarContenidoTabla("tablaComisiones");

    data.forEach(function (comision) {
        const row = tabla.insertRow();
        const cells = [comision.CodigoComision, comision.Nombre, comision.Restricciones, comision.Bono];

        cells.forEach((cellData, index) => {
            const cell = row.insertCell(index);
            cell.innerHTML = cellData;
        });

        const cellButtons = row.insertCell(cells.length);
        cellButtons.innerHTML = `<td>
            <button type="button" class="btn btn-outline-success btn-sm ms-1 edit-button-comision" data-bs-toggle="modal" data-bs-target="#modalComision" data-codigo-comision="${comision.CodigoComision}" data-nombre-comision="${comision.Nombre}" data-restricciones-comision="${comision.Restricciones}" data-bono-comision="${comision.Bono}">
                <i class="fas fa-edit"></i>
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm ms-1 delete-button-comision" data-bs-toggle="modal" data-bs-target="#eliminarComisionModal" data-codigo-comision="${comision.CodigoComision}" data-nombre-comision="${comision.Nombre}">
                <i class="fas fa-trash"></i>
            </button>
        </td>`;
    });

    asignarEventosBotonesComision();
}

function asignarEventosBotonesComision() {
    const editButtons = document.querySelectorAll(".edit-button-comision");
    const deleteButtons = document.querySelectorAll(".delete-button-comision");

    editButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta("Comision");
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

    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta("EliminarComision");
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

function btnNuevaComision() {
    restablecerAlerta("Comision");
    limpiarCamposModal("formComision");
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
        mostrarAlerta('Comision', 'Por favor complete los campos necesarios', 'advertencia');
    } else {

        const option = codigoComision === "" ? 4 : 5;

        let datos = {
            codigoComision: codigoComision,
            nombreComision: nombreComision,
            restriccionesComision: restriccionesComision,
            bonoComision: bonoComision,
            option: option
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/administracion.departamento-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            switch (xhr.status) {
                case 200:
                    cargarComisiones();
                    limpiarCamposModal("formComision");
                    cerrarModal("modalComision");
                    mostrarModalExitoso("modalGuardarExitoso");
                    break;
                case 409:
                    mostrarAlerta('Comision', 'Ya se encuentra el registro en el sistema', 'advertencia');
                    break;
                case 400:
                    mostrarAlerta('Comision', 'No se realizaron cambios', 'info');
                    break;
                default:
                    mostrarAlerta('Comision', 'Ocurrió un error inesperado', 'error');
                    break;
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
    xhr.open("POST", "../controllers/administracion.departamento-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarComisiones();
            cerrarModal("eliminarComisionModal");
            mostrarModalExitoso("modalEliminacionExitosa");
        } else {
            mostrarAlerta('EliminarComision', 'Ocurrio un error inesperado', 'error');

        }
    };
    xhr.send(JSON.stringify(datos));
}

function cargarUsuarios(busqueda) {
    const selectIds = (busqueda === "") ? ["CodigoUsuarioSistema", "tablaUsuarios"] : ["tablaUsuarios"];

    selectIds.forEach(function (selectId) {
        const xhr = new XMLHttpRequest();
        const url = "../controllers/administracion.usuario-controller.php?option=1&busqueda=" + encodeURIComponent(busqueda);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                if (selectId === "CodigoUsuarioSistema" && busqueda === "") {
                    limpiarSelect(selectId);
                    const select = document.getElementById(selectId);

                    data.forEach(function (usuario) {
                        const option = document.createElement("option");
                        option.value = usuario.Codigo;
                        option.text = usuario.Email;
                        select.appendChild(option);
                    });
                } else if (selectId === "tablaUsuarios" && data.length > 0) {
                    const tabla = document.getElementById("tablaUsuarios").getElementsByTagName("tbody")[0];

                    borrarContenidoTabla("tablaUsuarios");

                    data.forEach(function (usuario) {
                        const row = tabla.insertRow();
                        for (let i = 0; i < 3; i++) {
                            const cell = row.insertCell(i);
                            cell.innerHTML = (i === 0) ? usuario.Codigo : (i === 1) ? usuario.Email : (i === 2) ? usuario.Rol : '';
                        }

                        const cell4 = row.insertCell(3);
                        cell4.innerHTML = '<td>' +
                            `<button type="button" class="btn btn-outline-success btn-sm ms-1 edit-button-usuario" data-bs-toggle="modal" data-bs-target="#modalUsuario" data-codigo-usuario="${usuario.Codigo}" data-email="${usuario.Email}" data-rol="${usuario.CodigoRol}">` +
                            '<i class="fas fa-edit"></i>' +
                            '</button>' +
                            `<button type="button" class="btn btn-outline-danger btn-sm ms-1 delete-button-usuario" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal" data-codigo-usuario="${usuario.Codigo}" data-email="${usuario.Email}">` +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</td>';
                    });

                    asignarEventosBotonesUsuario();
                }
            }
        };

        xhr.send();
    });
}

function asignarEventosBotonesUsuario() {
    const editButtons = document.querySelectorAll(".edit-button-usuario");
    editButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta("Usuario");
            // Obtén los datos personalizados del botón
            const titulo = document.getElementById("tituloModalUsuario");
            titulo.innerHTML = "Editar Usuario";
            const labelClaveEditar = document.getElementById("lblClave");
            labelClaveEditar.innerHTML = "Clave (dejar en blanco si no se requiere modificar)";

            const codigo = button.getAttribute("data-codigo-usuario");
            const email = button.getAttribute("data-email");
            const rol = button.getAttribute("data-rol");

            // Rellena los campos del modal con los datos obtenidos
            document.getElementById("codigoUsuario").value = codigo;
            document.getElementById("emailUsuario").value = email;
            document.getElementById("selectUsuarioRol").value = rol;
        });
    });

    const deleteButtons = document.querySelectorAll(".delete-button-usuario");
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta("EliminarUsuario");
            const codigo = button.getAttribute("data-codigo-usuario");
            const email = button.getAttribute("data-email");

            // Rellena los campos del modal con los datos obtenidos
            const eliminarModalEmail = document.getElementById("descripcionEliminarUsuario");
            eliminarModalEmail.innerHTML = email;
            const codigoEliminar = document.getElementById('codigoEliminarUsuario');
            codigoEliminar.innerHTML = codigo;
        });
    });
}

function buscarUsuario() {
    let busquedaUsuario = document.getElementById('usuarioBusqueda').value;
    cargarUsuarios(busquedaUsuario);
}

function btnNuevoUsuario() {

    restablecerAlerta("Usuario");
    limpiarCamposUsuarioModal();
    document.getElementById('btnGuardarUsuario').removeAttribute('hidden');
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
        mostrarAlerta('Usuario', 'Por favor complete los campos necesarios', 'advertencia');
    } else {

        const option = codigo === "" ? 1 : 2;

        let datos = {
            codigoUsuario: codigo,
            clave: clave,
            email: email,
            rol: rol,
            option: option
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/administracion.usuario-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {
            switch (xhr.status) {
                case 200:
                    cargarUsuarios("");
                    limpiarCamposUsuarioModal();
                    cerrarModal("modalUsuario");
                    mostrarModalExitoso("modalGuardarExitoso");
                    break;
                case 409:
                    mostrarAlerta('Usuario', 'Ya se encuentra el registro en el sistema', 'advertencia');
                    break;
                case 400:
                    mostrarAlerta('Usuario', 'No se realizaron cambios', 'info');
                    break;
                default:
                    mostrarAlerta('Usuario', 'Ocurrió un error inesperado', 'error');
                    break;
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
    xhr.open("POST", "../controllers/administracion.usuario-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarUsuarios("");
            cerrarModal("eliminarUsuarioModal");
            mostrarModalExitoso("modalEliminacionExitosa");
        } else {
            mostrarAlerta('EliminarUsuario', 'Ocurrio un error inesperado', 'error');
        }
    };
    xhr.send(JSON.stringify(datos));
}

const NOMBRES_PERMISOS = ["Nomina", "Empleados", "Menu", "Reportes", "Caja", "Prestamos"];
const PERMISOS = ["Nomina", "Empleados", "Menu", "Reportes", "Caja", "Prestamos"];

function cargarRoles() {
    const selectIds = ["selectUsuarioRol", "tablaRoles"];

    selectIds.forEach(function (selectId) {
        const xhr = new XMLHttpRequest();
        const url = `../controllers/administracion.usuario-controller.php?option=${encodeURIComponent(2)}`;

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                if (selectId === "selectUsuarioRol") {
                    cargarSelectUsuarioRol(data);
                } else if (selectId === "tablaRoles") {
                    cargarTablaRoles(data);
                }
            }
        };

        xhr.send();
    });
}

function cargarSelectUsuarioRol(data) {
    const select = document.getElementById("selectUsuarioRol");
    limpiarSelect("selectUsuarioRol");

    data.forEach(function (rol) {
        const option = document.createElement("option");
        option.value = rol.CodigoRol;
        option.text = rol.Nombre;
        select.appendChild(option);
    });
}

function cargarTablaRoles(data) {
    const tabla = document.getElementById("tablaRoles").getElementsByTagName("tbody")[0];
    borrarContenidoTabla("tablaRoles");

    data.forEach(function (rol) {
        const row = tabla.insertRow();

        for (let i = 0; i < 8; i++) {
            const cell = row.insertCell(i);
            switch (i) {
                case 0:
                    cell.innerHTML = rol.CodigoRol;
                    break;
                case 1:
                    cell.innerHTML = rol.Nombre;
                    break;
                default:
                    cell.innerHTML = rol[`Gestiona${NOMBRES_PERMISOS[i - 2]}`].toString() === "1" ? "X" : "";
            }
        }

        const buttonsHTML = `
            <td>
                <button type="button" class="btn btn-outline-success btn-sm ms-1 edit-button-rol"
                    data-bs-toggle="modal" data-bs-target="#modalRol" data-codigo-rol="${rol.CodigoRol}"
                    data-nombre-rol="${rol.Nombre}" ${crearAtributosDatosRol(rol)}>
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm ms-1 delete-button-rol"
                    data-bs-toggle="modal" data-bs-target="#eliminarRolModal" data-codigo-rol="${rol.CodigoRol}"
                    data-nombre-rol="${rol.Nombre}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>`;

        row.innerHTML += buttonsHTML;
    });

    asignarEventosBotonesRol("edit-button-rol", "delete-button-rol", "Rol");
}

function crearAtributosDatosRol(rol) {
    return Object.keys(rol)
        .filter(key => key.startsWith("Gestiona"))
        .map(key => `data-${key.toLowerCase()}="${rol[key]}"`)
        .join(" ");
}

function asignarEventosBotonesRol(editClassName, deleteClassName, entidad) {
    const editButtons = document.querySelectorAll(`.${editClassName}`);
    editButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta(entidad);
            document.getElementById('btnGuardar' + entidad).removeAttribute('hidden');

            let titulo = document.getElementById("tituloModal" + entidad);
            titulo.innerHTML = "Editar " + entidad;

            let codigoRol = button.getAttribute("data-codigo-rol");
            let nombreRol = button.getAttribute("data-nombre-rol");

            let datos = {};
            for (const key in button.dataset) {
                if (button.dataset.hasOwnProperty(key) && button.dataset[key] !== "undefined") {
                    datos[key] = button.dataset[key];
                }
            }

            let codigoRolHidden = document.getElementById("codigoRol");
            codigoRolHidden.innerHTML = codigoRol;
            document.getElementById("nombre" + entidad).value = nombreRol;

            for (let i = 0; i < PERMISOS.length; i++) {
                let permiso = PERMISOS[i];
                document.getElementById(`gestiona${permiso}`).checked = datos[`gestiona${permiso.toLowerCase()}`] === "1";
            }
        });
    });

    const deleteButtons = document.querySelectorAll(`.${deleteClassName}`);
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            restablecerAlerta("Eliminar"+entidad);
            let codigo = button.getAttribute("data-codigo-" + entidad);
            let nombre = button.getAttribute("data-nombre-" + entidad);

            let eliminarModalEmail = document.getElementById("descripcionEliminar" + entidad);
            eliminarModalEmail.innerHTML = nombre;

            let codigoEliminar = document.getElementById('codigoEliminar' + entidad);
            codigoEliminar.innerHTML = codigo;
        });
    });
}

function btnNuevoRol() {

    limpiarCamposModal("formRol");
    restablecerAlerta("Rol");
    let titulo = document.getElementById("tituloModalRol");
    titulo.innerHTML = "Nuevo Rol";
    let codigoRol = document.getElementById("codigoRol");
    codigoRol.innerHTML = "";

}

function guardarRol() {
    const formulario = document.getElementById("formRol");
    const checkboxes = formulario.querySelectorAll('input[name="permiso[]"]');
    const codigoRolHidden = document.getElementById("codigoRol").textContent;
    const nombreRol = document.getElementById("nombreRol").value;

    // Mostrar alerta si el nombreRol está vacío
    if (nombreRol === "") {
        mostrarAlerta('Rol', 'Por favor complete los campos necesarios', 'advertencia');
        return; 
    }

    checkboxes.forEach(checkbox => checkbox.value = checkbox.checked ? 1 : 0);

    const permisosArray = Array.from(checkboxes, checkbox => checkbox.value);

    // Definir la opción según la condición
    const option = (codigoRolHidden === "" || nombreRol === "") ? 4 : 5;

    const datos = {
        codigoRol: codigoRolHidden,
        nombreRol: nombreRol,
        permisos: permisosArray,
        option: option,
    };

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/administracion.usuario-controller.php", true);
    xhr.setRequestHeader("Content-type", "application/json"); // Cambiado a 'application/json'

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            switch (xhr.status) {
                case 200:
                    cargarRoles();
                    cerrarModal("modalRol");
                    mostrarModalExitoso("modalGuardarExitoso");
                    limpiarCamposModal("formRol");
                    break;
                case 409:
                    mostrarAlerta('Rol', 'Ya se encuentra el registro en el sistema', 'advertencia');
                    break;
                case 400:
                    mostrarAlerta('Rol', 'No se realizaron cambios', 'info');
                    break;
                default:
                    mostrarAlerta('Rol', 'Ocurrio un error inesperado', 'error');
            }
        }
    };

    // Enviamos los datos al formulario
    xhr.send(JSON.stringify(datos)); // Se utiliza JSON.stringify para convertir el objeto a cadena JSON
}


function eliminarRol() {
    var codigoRol = document.getElementById('codigoEliminarRol').textContent;
    let datos = {
        codigoRol: codigoRol,
        option: 6
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/administracion.usuario-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            cargarRoles();
            cerrarModal('eliminarRolModal');
            mostrarModalExitoso("modalEliminacionExitosa");
        } else {
            mostrarAlerta('EliminarRol', 'Ocurrio un error inesperado', 'error');
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

function limpiarCamposUsuarioModal() {
    let FormularioUsuario = document.getElementById('formUsuario');
    FormularioUsuario.reset();

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

function limpiarCamposModal(modal) {
    let FormularioDepartamento = document.getElementById(modal);
    FormularioDepartamento.reset();
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

function mostrarAlerta(section, mensaje, tipo) {
    const alerta = document.getElementById('alerta'+section);
    const mensajeAlerta = document.getElementById('mensajeAlerta'+section);

    alerta.removeAttribute('hidden');
    mensajeAlerta.innerHTML = mensaje;

    // Define clases de estilo según el tipo de alerta
    alerta.className = "row m-2";
    switch (tipo) {
        case 'exito':
            alerta.classList.add('bg-success', 'bg-opacity-75', 'rounded-2');
            break;
        case 'error':
            alerta.classList.add('bg-danger', 'rounded-2');
            break;
        case 'info':
            alerta.classList.add('bg-info', 'bg-opacity-75', 'rounded-2');
            break;
        case 'advertencia':
            alerta.classList.add('bg-warning', 'rounded-2');
            break;
    }
}

function restablecerAlerta(section) {
    const alerta = document.getElementById('alerta'+section);
    alerta.setAttribute('hidden', true);
}

function cerrarModal(modalId) {
    var closeButton = document.getElementById(modalId).getElementsByClassName('btn-close')[0];
    if (closeButton) {
        closeButton.click();
    }
}

function mostrarModalExitoso(modalId) {
    var modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
}