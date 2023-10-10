<?php

require_once("../dao/usuario-dao.php");
$user = new UsuarioDAO();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $option = $_GET['option'];
    $usuarioBusqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";

    switch ($option) {
        case 1:
            obtenerUsuarios($usuarioBusqueda);
            break;
        case 2:
            obtenerRoles();
            break;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"));
    $option = $data->option;

    switch ($option) {
        case 1:
            $email = $data->email;
            $clave = $data->clave;
            $rol = $data->rol;
            guardarUsuario($email, $clave, $rol);
            break;
        case 2:
            $codigoUsuario = $data->codigoUsuario;
            $email = $data->email;
            $clave = $data->clave;
            $rol = $data->rol;

            actualizarUsuario($codigoUsuario, $email, $clave, $rol);
            break;
        case 3:
            $codigoUsuario = $data->codigoUsuario;
            eliminarUsuario(intval($codigoUsuario));
            break;
        case 4:
            $nombreRol = $data->nombreRol;
            $permisos = $data->permisos;
            guardarRol($nombreRol, $permisos[0], $permisos[1], $permisos[2], $permisos[3], $permisos[4], $permisos[5]);
            break;
        case 5:
            $codigoRol = $data->codigoRol;
            $nombreRol = $data->nombreRol;
            $permisos = $data->permisos;
            actualizarRol($codigoRol, $nombreRol, $permisos[0], $permisos[1], $permisos[2], $permisos[3], $permisos[4], $permisos[5]);
            break;
        case 6:
            $codigoRol = $data->codigoRol;
            eliminarRol($codigoRol);
            break;
    }
} else {
    http_response_code(400); // Solicitud incorrecta
}

function obtenerUsuarios(string $usuarioBusqueda)
{
    global $user;

    try{
        if (empty($usuarioBusqueda)) {
            $result = $user->listarUsuarios();
        } else {
            $result = $user->listarUsuariosBusqueda($usuarioBusqueda);
        }
    
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
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }catch(PDOException $ex){
        http_response_code(500); // Error en el servidor
    }
    
}

function guardarUsuario(string $email, string $clave, int $rol)
{

    global $user;
    try{
        $existe = $user->validarExistenciaUsuario($email);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
        if ($existe->Existe == 1) {
            http_response_code(409);
        } else {
            $result = $user->guardarUsuario($email, $clave, $rol);
            if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
                /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }
    }catch(PDOException $ex){
        http_response_code(500);
    }
    
}

function actualizarUsuario(int $codigo, string $email, string $clave, int $rol)
{

    global $user;

    try{
        $existe = $user->validarExistenciaUsuario($email);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
    
        if ($existe->Existe == 1 & $existe->CodigoUsuarioSistema != $codigo) {
            http_response_code(409);
        } else {
            if (empty($clave)) {
                $result = $user->actualizarUsuarioNoClave($codigo, $email, $rol);
            } else {
                $result = $user->actualizarUsuario($codigo, $email, $clave, $rol);
            }
    
            if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
                /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }
    }catch(PDOException $ex){
        http_response_code(500);
    }
    
}

function eliminarUsuario(int $codigoUsuario)
{

    global $user;
    
    try{
        $result = $user->eliminarUsuario($codigoUsuario);

        if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
            /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }catch(PDOException $ex){
        http_response_code(500);
    }
    
}

function obtenerRoles()
{
    global $user;

    try{
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
            http_response_code(400); // NO HAY REGISTROS
        }
    }catch(PDOException $ex){
        http_response_code(500); 
    }
    
}
function guardarRol(string $nombre, int $gestionaNomina, int $gestionaEmpleados, int $gestionaMenu, int $gestionaReportes, int $gestionaCaja, int $asistencia)
{
    global $user;
    try{
        $existe = $user->validarExistenciaRol($nombre);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
    
        if ($existe->Existe == 1) {
            http_response_code(409);
        } else {
            $result = $user->guardarRol($nombre, $gestionaNomina, $gestionaEmpleados, $gestionaMenu, $gestionaReportes, $gestionaCaja, $asistencia);
            if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
    
                if ($result->rowCount() > 0) {
                    /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }
            }
        }
    }catch(PDOException $ex){
        http_response_code(500);
    }
    
}

function actualizarRol(int $codigoRol, string $nombre, int $gestionaNomina, int $gestionaEmpleados, int $gestionaMenu, int $gestionaReportes, int $gestionaCaja, int $asistencia)
{
    global $user;
    try{
        $existe = $user->validarExistenciaRol($nombre);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
    
        if ($existe->Existe == 1 & $existe->CodigoRol != $codigoRol) {
            http_response_code(409);
        } else {
            $result = $user->actualizarRol($codigoRol, $nombre, $gestionaNomina, $gestionaEmpleados, $gestionaMenu, $gestionaReportes, $gestionaCaja, $asistencia);
    
            if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
                /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }
    }catch(PDOException $ex){
        http_response_code(500);
    }
    
}

function eliminarRol(int $codigoRol)
{
    global $user;
    try{
        $result = $user->eliminarRol($codigoRol);
        if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
            /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }catch(PDOException $ex){
        http_response_code(500);
    }
    
}

?>