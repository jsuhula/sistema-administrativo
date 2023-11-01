(function (){
    calcularPagoBono14();
})();

function calcularPagoBono14() {

    let fecha = document.getElementById('fechaPagoBono14').value;
    if (fecha !== "") {

        var xhr = new XMLHttpRequest();
        var url = "../controllers/nomina-controller.php?option=" + encodeURIComponent(2) + "&codigoTipoBonificacion=" + encodeURIComponent(1) + "&fechaOperacion=" + encodeURIComponent(fecha);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onload = function () {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                let fecha = "";

                var tabla = document.getElementById("tablaPagoBono14").getElementsByTagName("tbody")[0];
                    /* BORRA LA TABLA PARA QUE ESTA NO SE DUPLIQUE AL LISTAR LOS REGISTROS */
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
                    fecha = document.getElementById('fechaReporte').value;
                    html2pdf().set({
                        margin: 0.5,
                        filename: "Reporte-Bono14" + "-" + fecha,
                        image: {
                            type: 'jpeg',
                            quality: 0.999
                        },
                        html2camvas: {
                            scale: 1,
                            letterRendering: false,
                        },
                        jsPDF: {
                            unit: "in",
                            format: "legal",
                            orientation: 'landscape'
                        }
                    }).from(document.body).save().catch(err => console.log(err));
            }
        };

        xhr.send();
    }
}