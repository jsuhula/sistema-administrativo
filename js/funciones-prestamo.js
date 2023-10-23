(function () {

    cargarPrestamos("");
    cargarEmpleados();

})();

function buscarPrestamo() {
    let empleadoBusqueda = document.getElementById('empleadoBusqueda').value;
    cargarPrestamos(empleadoBusqueda);
}


function cargarPrestamos(empleadoBusqueda) {

    var xhr = new XMLHttpRequest();
    var url = "../controllers/prestamo-controller.php?option=" + encodeURIComponent(1)+"&nombreEmpleado="+encodeURIComponent(empleadoBusqueda);

    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            var tabla = document.getElementById("tablaPrestamos").getElementsByTagName("tbody")[0];

            borrarContenidoTabla("tablaPrestamos");

            data.forEach(function (prestamo) {
                var row = tabla.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                cell1.innerHTML = prestamo.CodigoPrestamo;
                cell2.innerHTML = prestamo.Fecha;
                cell3.innerHTML = prestamo.NombreEmpleado;
                cell4.innerHTML = prestamo.Cuotas;
                cell5.innerHTML = prestamo.CuotasPendientes;
                cell6.innerHTML = prestamo.Monto;
                cell7.innerHTML = prestamo.SaldoPendiente < 0 ? "0.00" : prestamo.SaldoPendiente;
            });

        }
    };

    xhr.send();
}

function btnNuevoPrestamo() {
    restablecerAlertas("Prestamo");
    limpiarCamposModal("Prestamo");
    document.getElementById('btnGuardarPrestamo').removeAttribute('hidden');
    document.getElementById('alertaCompletarCamposPrestamo').setAttribute('hidden', true);
}


function guardarPrestamo() {

    let formulario = document.getElementById("formPrestamo");
    let fechaPrestamo = formulario.fechaPrestamo.value;
    let montoPrestamo = formulario.montoPrestamo.value;
    let selectEmpleadoPrestamo = formulario.selectEmpleadoPrestamo.value;
    let selectCuotasPrestamo = formulario.selectCuotasPrestamo.value;

    if (fechaPrestamo === "" || montoPrestamo === "" || selectEmpleadoPrestamo === "" || selectCuotasPrestamo === "") {
        document.getElementById('alertaCompletarCamposPrestamo').removeAttribute('hidden');
    } else {
        document.getElementById('alertaCompletarCamposPrestamo').setAttribute('hidden', true);
        var datos = {
            fecha: fechaPrestamo,
            monto: montoPrestamo,
            cuotas: selectCuotasPrestamo,
            codigoEmpleado: selectEmpleadoPrestamo,
            option: 1
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/prestamo-controller.php", true);
        xhr.setRequestHeader("Content-type", "application/json");

        xhr.onreadystatechange = function () {
            console.log(xhr.responseText);
            if (xhr.status === 200) {
                cargarPrestamos("");
                alertasExitoGuardar("Prestamo");
                formulario.reset();
            } else if (xhr.status === 409) {
                alertaDuplicado("Prestamo");
            } else if (xhr.status === 400) {
                alertaNoAfectacion("Prestamo");
            } else if (xhr.status === 401) {
                alertaExistePrestamoPendiente();
            } else {
                alertasErrorGuardar("Prestamo");
            }
        };

        // Enviamos los datos al formulario
        xhr.send(JSON.stringify(datos));
    }
}


function cargarEmpleados() {

    var xhr = new XMLHttpRequest();
    var url = "../controllers/empleado-controller.php?option=" + encodeURIComponent(1);
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            limpiarSelect("selectEmpleadoPrestamo");
            var select = document.getElementById("selectEmpleadoPrestamo");

            data.forEach(function (empleado) {
                var option = document.createElement("option");
                option.value = empleado.CodigoEmpleado;
                option.text = empleado.NombreCompleto;
                select.appendChild(option);
            });
        } else {
            console.log("Error");
        }
    };

    xhr.send();
}

function cargarPrestamoValidacion() {

    let formulario = document.getElementById("formAbono");
    let codigoPrestamo = formulario.codigoPrestamo.value;

    if (codigoPrestamo === "") {
        restablecerAlertas('Abono');
        document.getElementById('alertaValidacion').removeAttribute('hidden');
    } else {

        var xhr = new XMLHttpRequest();
        var url = "../controllers/prestamo-controller.php?option=" + encodeURIComponent(2) + "&codigoPrestamo=" + encodeURIComponent(codigoPrestamo);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('alertaValidacion').setAttribute('hidden', true);
                var data = JSON.parse(xhr.responseText);

                document.getElementById('codigoPrestamoValidacion').innerHTML = data[0].CodigoPrestamo;
                document.getElementById('empleadoPrestamoValidacion').innerHTML = data[0].CodigoEmpleado;
                document.getElementById('montoPrestamoValidacion').innerHTML = data[0].Monto;
                document.getElementById('saldoPendienteValidacion').innerHTML = data[0].SaldoPendiente;
                document.getElementById('montoCuotaValidacion').innerHTML = parseFloat(data[0].MontoCuota).toFixed(2);

            } else {
                console.log("Error");
            }
        };

        xhr.send();
    }
}

function btnNuevoAbono() {
    restablecerAlertas("Abono");
    limpiarCamposModal('Abono');
    limpiarCamposValidacion();
    document.getElementById('btnGuardarAbono').removeAttribute('hidden');
    document.getElementById('btnValidarPrestamo').removeAttribute('hidden');
    document.getElementById('alertaCompletarCamposAbono').setAttribute('hidden', true);
}

function guardarAbono() {

    let formulario = document.getElementById("formAbono");
    let fechaAbono = formulario.fechaAbono.value;
    let codigoPrestamo = formulario.codigoPrestamo.value;
    let selectCuotasAbonarPrestamo = formulario.selectCuotasAbonarPrestamo.value;

    if (fechaAbono === "" || codigoPrestamo === "" || selectCuotasAbonarPrestamo === "") {
        document.getElementById('alertaCompletarCamposAbono').removeAttribute('hidden');
        document.getElementById('alertaValidacion').setAttribute('hidden', true);
    } else {
        document.getElementById('alertaCompletarCamposAbono').setAttribute('hidden', true);
        var datos = {
            fecha: fechaAbono,
            codigoPrestamo: codigoPrestamo,
            cuotas: selectCuotasAbonarPrestamo,
            option: 2
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/prestamo-controller.php", true);
        xhr.setRequestHeader("Content-type", "application/json");

        xhr.onreadystatechange = function () {
            console.log(xhr.responseText);
            if (xhr.status === 200) {
                document.getElementById('btnValidarPrestamo').setAttribute('hidden', true);
                cargarPrestamos('');
                limpiarCamposValidacion();
                alertasExitoGuardar("Abono");
                formulario.reset();
            } else if (xhr.status === 400) {
                alertaNoAfectacion("Abono");
            } else if (xhr.status === 401) {
                alertaExistePrestamoPendiente();
            } else {
                alertasErrorGuardar("Abono");
            }
        };

        // Enviamos los datos al formulario
        xhr.send(JSON.stringify(datos));
    }
}

function borrarContenidoTabla(nombreTabla) {
    var tabla = document.getElementById("" + nombreTabla + "");
    var tbody = tabla.getElementsByTagName("tbody")[0];

    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
}

function limpiarSelect(selectId) {

    var select = document.getElementById(selectId);
    while (select.options.length > 1) {
        select.remove(1);
    }
}

function limpiarCamposModal(modal) {
    let formulario = document.getElementById('form' + modal);
    formulario.reset();
}

function restablecerAlertas(section) {
    document.getElementById('btnGuardar' + section).removeAttribute('hidden');
    document.getElementById('alertaExito' + section).setAttribute('hidden', true);
    document.getElementById('alertaError' + section).setAttribute('hidden', true);
    document.getElementById('alertaDuplicado' + section).setAttribute('hidden', true);
    document.getElementById('alertaNoAfectacion' + section).setAttribute('hidden', true);
    document.getElementById('alertaCompletarCampos' + section).setAttribute('hidden', true);
    document.getElementById('alertaEmpleadoExiste' + section).setAttribute('hidden', true);
}

function alertasExitoGuardar(section) {
    document.getElementById('alertaExito' + section).removeAttribute('hidden');
    document.getElementById('alertaError' + section).setAttribute('hidden', true);
    document.getElementById('alertaDuplicado' + section).setAttribute('hidden', true);
    document.getElementById('alertaNoAfectacion' + section).setAttribute('hidden', true);
    document.getElementById('alertaEmpleadoExiste' + section).setAttribute('hidden', true);
    document.getElementById('btnGuardar' + section).setAttribute('hidden', true);
}

function alertasErrorGuardar(section) {
    document.getElementById('alertaExito' + section).setAttribute('hidden', true);
    document.getElementById('alertaError' + section).removeAttribute('hidden');
    document.getElementById('alertaDuplicado' + section).setAttribute('hidden', true);
    document.getElementById('alertaEmpleadoExiste' + section).setAttribute('hidden', true);
}

function alertaDuplicado(section) {
    document.getElementById('alertaDuplicado' + section).removeAttribute('hidden');
    document.getElementById('alertaNoAfectacion' + section).setAttribute('hidden', true);
    document.getElementById('alertaEmpleadoExiste' + section).setAttribute('hidden', true);
}

function alertaExistePrestamoPendiente() {
    document.getElementById('alertaEmpleadoExistePrestamo').removeAttribute('hidden');
}

function limpiarCamposValidacion() {
    document.getElementById('codigoPrestamoValidacion').innerHTML = "";
    document.getElementById('empleadoPrestamoValidacion').innerHTML = "";
    document.getElementById('montoPrestamoValidacion').innerHTML = "";
    document.getElementById('saldoPendienteValidacion').innerHTML = "";
    document.getElementById('montoCuotaValidacion').innerHTML = "";
}