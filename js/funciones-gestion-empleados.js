(function () {

    cargarUsuarios();

})();


function cargarUsuarios() {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", "../controllers/usuario-controller.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            var tabla = document.getElementById("tablaUsuarios").getElementsByTagName("tbody")[0];

            /* BORRA LA TABLA PARA QUE ESTA NO SE DUPLIQUE AL LISTAR LOS REGISTROS */
            borrarContenidoTabla();

            data.forEach(function (usuario) {
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

                cell1.innerHTML = usuario.Codigo;
                cell2.innerHTML = usuario.Email;
                cell3.innerHTML = usuario.Rol;
                cell4.innerHTML = usuario.Nomina;
                cell5.innerHTML = usuario.Empleados;
                cell6.innerHTML = usuario.Menu;
                cell7.innerHTML = usuario.Reportes;
                cell8.innerHTML = usuario.Caja;
                cell9.innerHTML = '<td class="m-auto">' +
                    '<button type="button" class="btn btn-success btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#eliminar">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</td>';
            });
        } else {
            alert("Error al cargar los usuarios.");
        }
    };

    xhr.send();
}

function borrarContenidoTabla() {
    var tabla = document.getElementById("tablaUsuarios");
    var tbody = tabla.getElementsByTagName("tbody")[0];

    // Borra todas las filas del cuerpo de la tabla
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
}