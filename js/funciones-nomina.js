function calcularNominaSalario() {

    let fecha = document.getElementById('fechaNominaSalario').value;
    if (fecha !== "") {

        var xhr = new XMLHttpRequest();
        var url = "../controllers/nomina-controller.php?option=" + encodeURIComponent(1) + "&fechaOperacion=" + encodeURIComponent(fecha);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                var tabla = document.getElementById("tablaNominaSalario").getElementsByTagName("tbody")[0];

                    /* BORRA LA TABLA PARA QUE ESTA NO SE DUPLIQUE AL LISTAR LOS REGISTROS */
                    borrarContenidoTabla("tablaNominaSalario");

                    data.forEach(function (registro) {
                        let row = tabla.insertRow();
                        let cell1 = row.insertCell(0);
                        let cell2 = row.insertCell(1);
                        let cell3 = row.insertCell(2);
                        let cell4 = row.insertCell(3);
                        let cell5 = row.insertCell(4);
                        let cell6 = row.insertCell(5);
                        let cell7 = row.insertCell(6);
                        let cell8 = row.insertCell(7);
                        let cell9 = row.insertCell(8);

                        cell1.innerHTML = registro.CodigoEmpleado;
                        cell2.innerHTML = registro.NombreCompleto;
                        cell3.innerHTML = Number(registro.SalarioBase).toFixed(2);
                        cell4.innerHTML = Number(registro.Comision).toFixed(2);
                        cell5.innerHTML = Number(registro.HorasExtras).toFixed(2);
                        cell6.innerHTML = Number(registro.IGSSEmpleado).toFixed(2);
                        cell7.innerHTML = Number(registro.IRTRA).toFixed(2);
                        cell8.innerHTML = Number(registro.CuotaPrestamo).toFixed(2);
                        cell9.innerHTML = Number(registro.SalarioNetoDevengado).toFixed(2);
                    });
            }
        };

        xhr.send();
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