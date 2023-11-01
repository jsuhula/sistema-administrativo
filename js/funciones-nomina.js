function calcularNominaSalario() {
    let fecha = document.getElementById('fechaNominaSalario').value;
    document.getElementById('existenciaReporteMesSeleccionado').setAttribute('hidden', true);
    if (fecha !== "") {

        var xhr = new XMLHttpRequest();
        var url = "../controllers/nomina-controller.php?option=" + encodeURIComponent(1) + "&fechaOperacion=" + encodeURIComponent(fecha);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                var tabla = document.getElementById("tablaNominaSalario").getElementsByTagName("tbody")[0];
                document.getElementById('confirmarOperacionNominaSalario').removeAttribute('disabled');
                document.getElementById('fechaNominaSalario').setAttribute('disabled', true);

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
                    cell2.innerHTML = Number(registro.SalarioBase).toFixed(2);
                    cell3.innerHTML = Number(registro.Comision).toFixed(2);
                    cell4.innerHTML = Number(registro.DevengadoHorasExtras).toFixed(2);
                    cell5.innerHTML = Number(registro.DescuentoHorasNoTrabajadas).toFixed(2);
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

function confirmarNominaSalario() {

    let fechaOperacion = document.getElementById('fechaNominaSalario').value;
    document.getElementById('existenciaReporteMesSeleccionado').setAttribute('hidden', true);
    if (fechaOperacion !== "") {
        let datos = {
            fechaOperacion: fechaOperacion,
            option: 1
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/nomina-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {

            if (xhr.status === 200) {
                document.getElementById('confirmarOperacionNominaSalario').setAttribute('disabled', true);
                window.open('../templates/reporte-nomina-salarios.php?fechaOperacion=' + fechaOperacion, '_blank');
                window.location.reload();
            } else if (xhr.status === 400) {
                document.getElementById('existenciaReporteMesSeleccionado').removeAttribute('hidden');
                document.getElementById('fechaNominaSalario').removeAttribute('disabled');
                document.getElementById('confirmarOperacionNominaSalario').setAttribute('disabled', true);
            } else {
                console.log(xhr.responseText);
            }
        };
        xhr.send(JSON.stringify(datos));
    }
}

function calcularBonificacion() {
    let bonificacionSeleccionada = document.getElementById('SelectTipoBonificacion').value;

    if (bonificacionSeleccionada === "1") {
        implCalcularPagoBonificacion(1);
    } else if (bonificacionSeleccionada === "2") {
        implCalcularPagoBonificacion(2);
    }
}

function implCalcularPagoBonificacion(codigoTipoBonificacion) {

    document.getElementById('existenciaPagoBonoSeleccionado').setAttribute('hidden', true);
    let fecha = document.getElementById('fechaPagoBono14').value;

    if (fecha !== "") {

        var xhr = new XMLHttpRequest();
        var url = "../controllers/nomina-controller.php?option=" + encodeURIComponent(2) + "&codigoTipoBonificacion=" + encodeURIComponent(codigoTipoBonificacion) + "&fechaOperacion=" + encodeURIComponent(fecha);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                var tabla = document.getElementById("tablaPagoBono14").getElementsByTagName("tbody")[0];
                document.getElementById('confirmarOperacionPagoBono14').removeAttribute('disabled');
                document.getElementById('fechaPagoBono14').setAttribute('disabled', true);
                document.getElementById('SelectTipoBonificacion').setAttribute('disabled', true);
                /* BORRA LA TABLA PARA QUE ESTA NO SE DUPLIQUE AL LISTAR LOS REGISTROS */
                borrarContenidoTabla("tablaPagoBono14");
                console.log(data);
                data.forEach(function (registro) {
                    let row = tabla.insertRow();
                    let cell1 = row.insertCell(0);
                    let cell2 = row.insertCell(1);
                    let cell3 = row.insertCell(2);
                    let cell4 = row.insertCell(3);
                    let cell5 = row.insertCell(4);

                    cell1.innerHTML = registro.FechaUltimoPago;
                    cell2.innerHTML = registro.NombreEmpleado;
                    cell3.innerHTML = registro.Profesion;
                    cell4.innerHTML = Number(registro.Bono14).toFixed(2);
                    cell5.innerHTML = Number(registro.Bono14).toFixed(2);

                });
            }else if (xhr.status === 400){
                document.getElementById('existenciaPagoBonoSeleccionado').removeAttribute('hidden');
            }
        };

        xhr.send();
    }
}

function confirmarPagoBonificacion() {
    let bonificacionSeleccionada = document.getElementById('SelectTipoBonificacion').value;

    if (bonificacionSeleccionada === "1") {
        implConfirmarPagoBonificacion(1);
    } else if (bonificacionSeleccionada === "2") {
        implConfirmarPagoBonificacion(2)
    }
}

function implConfirmarPagoBonificacion(codigoTipoBonificacion) {

    let fechaOperacion = document.getElementById('fechaPagoBono14').value;
    document.getElementById('existenciaPagoBonoSeleccionado').setAttribute('hidden', true);
    if (fechaOperacion !== "") {
        let datos = {
            fechaOperacion: fechaOperacion,
            codigoTipoBonificacion: codigoTipoBonificacion,
            option: 2
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/nomina-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {

            if (xhr.status === 200) {
                document.getElementById('confirmarOperacionPagoBono14').setAttribute('disabled', true);
                window.open('../templates/reporte-nomina-bono14.php?fechaOperacion=' + fechaOperacion, '_blank');
                window.location.reload();
            } else if (xhr.status === 400) {
                document.getElementById('existenciaPagoBonoSeleccionado').removeAttribute('hidden');
                document.getElementById('fechaPagoBono14').removeAttribute('disabled');
                document.getElementById('confirmarOperacionPagoBono14').setAttribute('disabled', true);
            }
        };
        xhr.send(JSON.stringify(datos));
    }
}

function exportarPagoBono14() {
    let fechaOperacion = document.getElementById('fechaInformePagoBono14').value;
    console.log(fechaOperacion);
    window.open('../templates/reporte-nomina-bono14.php?fechaOperacion=' + fechaOperacion, '_blank');
    //window.location.reload();
}

function validarExisteReporteNomina() {
    let fechaOperacion = document.getElementById('fechaInformeNominaSalario').value;
    document.getElementById('noExisteReporteNominaSalario').setAttribute('hidden', true);
    if (fechaOperacion !== "") {
        let datos = {
            fechaOperacion: fechaOperacion,
            option: 4
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controllers/nomina-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onload = function () {

            if (xhr.status === 200) {
                window.open('../templates/reporte-nomina-salarios.php?fechaOperacion=' + fechaOperacion, '_blank');
                window.location.reload();
            } else if (xhr.status === 400) {
                document.getElementById('noExisteReporteNominaSalario').removeAttribute('hidden');
            } else {
                console.log(xhr.responseText);
            }
        };
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
