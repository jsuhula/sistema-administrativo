<?php
require_once("../dao/departamento-dao.php");
$departamento = new DepartamentoDAO();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $option = $_GET['option'];

    switch ($option) {
        case 1:
            obtenerDepartamento();
            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"));
    $option = $data->option;

    switch ($option) {
        case 1:
            $nombre = $data->nombre;
            $codigoComision = $data->codigoComision;
            $codigoEmpleado = $data->codigoEmpleado;
            guardarDepartamento($nombre, $codigoComision, $codigoEmpleado);
            break;
        case 2:
            $codigoDepartamento = $data->codigoDepartamento;
            $nombre = $data->nombre;
            $codigoComision = $data->codigoComision;
            $codigoEmpleado = $data->codigoEmpleado;
            actualizarDepartamento($codigoDepartamento, $nombre, $codigoComision, $codigoEmpleado);
            break;
        case 3:
            $codigoDepartamento = $data->codigoDepartamento;
            eliminarDepartamento(intval($codigoDepartamento));
            break;
    }
} else {
    http_response_code(400); // Solicitud incorrecta
}

function obtenerDepartamento()
{
    global $departamento;
    $result = $departamento->listarDepartamento();

    if ($result->rowCount() > 0) {
        $registros = array(); // Almacena los registros en un arreglo

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $registros[] = $row;
        }

        $registrosJSON = json_encode($registros);

        // Devuelve los registros en formato JSON como respuesta HTTP
        header('Content-Type: application/json');
        echo $registrosJSON;
    } else {
        http_response_code(500); // Error en el servidor
    }
}

function guardarDepartamento(string $nombre, string $codigoComision, int $codigoEmpleado)
{

    global $departamento;
    $existe = $departamento->validarExistenciaDepartamento($nombre);
    $existe = $existe->fetch(PDO::FETCH_OBJ);
    if($existe->Existe == 1){
        http_response_code(409);
    }else{
        $result = $departamento->guardarDepartamento($nombre, $codigoComision, $codigoEmpleado);
        if ($result->rowCount() > 0) {
            /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    }
}

function actualizarDepartamento(int $codigoDepartamento, string $nombre, string $codigoComision, int $codigoEmpleado)
{
    global $departamento;
    $result = $departamento->actualizarDepartamento($codigoDepartamento, $nombre, $codigoComision, $codigoEmpleado);

    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}

function eliminarDepartamento(int $codigoDepartamento)
{
    global $departamento;
    $result = $departamento->eliminarDepartamento($codigoDepartamento);
    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}

?> 