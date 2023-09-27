<?php
require_once("../dao/usuario-dao.php");
$user = new UserDAO();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $option = $_GET['option'];

    switch ($option) {
        case 1:
            obtenerUsuarios();
            break;
        case 2:
            obtenerRoles();
            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"));

    $codigo = $data->codigo;
    $email = $data->email;
    $clave = hash('sha256', $data->clave);
    $rol = $data->rol;
    $option = $data->option;

    switch ($option) {
        case 1:
            guardarUsuario($email, $clave, $rol);
            break;
        case 2:
            actualizarUsuario($codigo, $email, $clave, $rol);
            break;
        case 3:
            eliminarUsuario($codigo);
            break;
    }
} else {
    http_response_code(400); // Solicitud incorrecta
}

function obtenerUsuarios()
{
    global $user;
    $result = $user->listarUsuarios();

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

function obtenerRoles()
{
    global $user;
    $result = $user->listarRoles();

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

    global $user;
    $result = $user->guardarUsuario($email, $clave, $rol);

    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}

function eliminarUsuario(int $codigoUsuarioSistema)
{

    global $user;
    $result = $user->eliminarUsuario($codigoUsuarioSistema);

    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}

function actualizarUsuario(int $codigo, string $email, string $clave, int $rol){

    global $user;
    if(empty($clave)){
        $result = $user->actualizarUsuarioNoClave($codigo, $email, $rol);
    }else{
        $result = $user->actualizarUsuario($codigo, $email, $clave, $rol);
    }

    if ($result->rowCount() > 0) {
        /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
?>