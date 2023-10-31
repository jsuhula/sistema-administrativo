(function (){
    calcularNominaSalario();
})();

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
                let fecha = "";

                var tabla = document.getElementById("tablaNominaSalario").getElementsByTagName("tbody")[0];
                    /* BORRA LA TABLA PARA QUE ESTA NO SE DUPLIQUE AL LISTAR LOS REGISTROS */
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
                        let cell10 = row.insertCell(9);
                        let cell11 = row.insertCell(10);
                        let cell12 = row.insertCell(11);
                        let cell13 = row.insertCell(12);
                        let cell14 = row.insertCell(13);

                        cell1.innerHTML = registro.NombreCompleto;
                        cell2.innerHTML = registro.Profesion;
                        cell3.innerHTML = Number(registro.SalarioBase).toFixed(2);
                        cell4.innerHTML = Number(registro.HorasTrabajadas).toFixed(2);
                        cell5.innerHTML = Number(registro.HorasExtras).toFixed(2);
                        cell6.innerHTML = Number(registro.PrecioHora).toFixed(2);
                        cell7.innerHTML = Number(registro.Comision).toFixed(2);
                        cell8.innerHTML = Number(registro.DevengadoHorasExtras).toFixed(2);
                        cell9.innerHTML = Number(registro.BonoIncentivo).toFixed(2);
                        cell10.innerHTML = Number(registro.DescuentoHorasNoTrabajadas).toFixed(2);
                        cell11.innerHTML = Number(registro.IGSSEmpleado).toFixed(2);
                        cell12.innerHTML = Number(registro.IRTRA).toFixed(2);
                        cell13.innerHTML = Number(registro.CuotaPrestamo).toFixed(2);
                        cell14.innerHTML = Number(registro.SalarioNetoDevengado).toFixed(2); 

                    });
                    fecha = document.getElementById('fechaReporte').value;
                    html2pdf().set({
                        margin: 0.5,
                        filename: "Reportte-Nomina" + "-" + fecha,
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