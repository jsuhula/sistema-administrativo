<?php
require_once("../dao/empleado-dao.php");
$empleado = new EmpleadoDAO();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $option = $_GET['option'];

    switch ($option) {
        case 1:
            obtenerEmpleados();
            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"));
    $option = $data->option;

    switch ($option) {
        case 1:
            $email = $data->email;
            $clave = hash('sha256', $data->clave);
            $rol = $data->rol;
            guardarUsuario($email, $clave, $rol);
            break;
        case 2:
            $codigoUsuario = $data->codigoUsuario;
            $email = $data->email;
            $clave = hash('sha256', $data->clave);
            $rol = $data->rol;

            actualizarUsuario($codigoUsuario, $email, $clave, $rol);
            break;
        case 3:
            $codigoUsuario = $data->codigoUsuario;
            eliminarUsuario(intval($codigoUsuario));
            break;
    }
} else {
    http_response_code(400); // Solicitud incorrecta
}

function obtenerEmpleados()
{
    global $empleado;
    $result = $empleado->listarEmpleados();

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

function guardarUsuario(string $email, string $clave, int $rol)
{

    global $empleado;
    $result = $empleado->guardarEmpleado($email, $clave, $rol);

    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}

function actualizarUsuario(int $codigo, string $email, string $clave, int $rol)
{

    global $user;
    if (empty($clave)) {
        $result = $user->actualizarUsuarioNoClave($codigo, $email, $rol);
    } else {
        $result = $user->actualizarUsuario($codigo, $email, $clave, $rol);
    }

    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}

function eliminarUsuario(int $codigoUsuario)
{

    global $user;
    $result = $user->eliminarUsuario($codigoUsuario);

    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}

?>