<?php

session_start();
if (!$_SESSION) {
  header('location: ../login.php');
}

use dao\EmpleadoDAO;

main();
function main()
{
    require_once('../dao/EmpleadoDAO.php');
    require_once('../includes/MySQLConnector.php');
    $empleado = new EmpleadoDAO();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $option = isset($_GET['option']) ? filter_var($_GET['option'], FILTER_SANITIZE_NUMBER_INT) : 0;
        $empleadoBusqueda = isset($_GET['busqueda']) ? filter_var($_GET['busqueda'], FILTER_SANITIZE_SPECIAL_CHARS) : "";
        $estado = isset($_GET['estado']) ? filter_var($_GET['estado'], FILTER_SANITIZE_NUMBER_INT) : 1;

        switch ($option) {
            case 1:
                obtenerEmpleados($empleadoBusqueda, intval($estado), $empleado);
                break;
            default:
                break;
        }
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"));
        $option = $data->option;

        switch ($option) {
            case 1:
                $nombres = $data->NombresEmpleado;
                $apellidos = $data->ApellidosEmpleado;
                $email = $data->EmailEmpleado;
                $telefono = $data->Telefono;
                $salarioBase = $data->SalarioBase;
                $fechaNacimiento = $data->FechaNacimiento;
                $fechaIngreso = $data->FechaIngreso;
                $fechaRetiro = $data->FechaRetiro;
                $profesion = $data->Profesion;
                $fotografia = "";
                $dpi = $data->Dpi;
                $nit = $data->Nit;
                $irtra = $data->Irtra;
                $igss = $data->Igss;
                $estado = $data->Estado;
                $codigoDepartamento = $data->CodigoDepartamento;
                $codigoUsuarioSistema = $data->CodigoUsuarioSistema;
                $codigoJornadaLaboral = $data->CodigoJornadaLaboral;
                guardarEmpleado(
                    $nombres,
                    $apellidos,
                    $email,
                    $telefono,
                    $salarioBase,
                    $fechaNacimiento,
                    $fechaIngreso,
                    $fechaRetiro,
                    $profesion,
                    $fotografia,
                    $dpi,
                    $nit,
                    $irtra,
                    $igss,
                    $estado,
                    $codigoDepartamento,
                    $codigoUsuarioSistema,
                    $codigoJornadaLaboral,
                    $empleado
                );
                break;
            case 2:
                $codigoEmpleado = $data->CodigoEmpleado;
                $nombres = $data->NombresEmpleado;
                $apellidos = $data->ApellidosEmpleado;
                $email = $data->EmailEmpleado;
                $telefono = $data->Telefono;
                $salarioBase = $data->SalarioBase;
                $fechaNacimiento = $data->FechaNacimiento;
                $fechaIngreso = $data->FechaIngreso;
                $fechaRetiro = $data->FechaRetiro;
                $profesion = $data->Profesion;
                $fotografia = "";
                $dpi = $data->Dpi;
                $nit = $data->Nit;
                $irtra = $data->Irtra;
                $igss = $data->Igss;
                $estado = $data->Estado;
                $codigoDepartamento = $data->CodigoDepartamento;
                $codigoUsuarioSistema = $data->CodigoUsuarioSistema;
                $codigoJornadaLaboral = $data->CodigoJornadaLaboral;
                actualizarEmpleado(
                    $codigoEmpleado,
                    $nombres,
                    $apellidos,
                    $email,
                    $telefono,
                    $salarioBase,
                    $fechaNacimiento,
                    $fechaIngreso,
                    $fechaRetiro,
                    $profesion,
                    $fotografia,
                    $dpi,
                    $nit,
                    $irtra,
                    $igss,
                    $estado,
                    $codigoDepartamento,
                    $codigoUsuarioSistema,
                    $codigoJornadaLaboral,
                    $empleado
                );
                break;
        }
    } else {
        http_response_code(400); // Solicitud incorrecta
    }
}

function obtenerEmpleados(string $empleadoBusqueda, int $estado, EmpleadoDAO $empleadoDao)
{

    try {
        if (empty($empleadoBusqueda)) {
            $result = $empleadoDao->listarEmpleados($estado);
        } else {
            $result = $empleadoDao->listarEmpleadosBusqueda($empleadoBusqueda, $estado);
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
    } catch (PDOException $ex) {
        http_response_code(500); // Error en el servidor
    }

}
function guardarEmpleado(
    string $nombres,
    string $apellidos,
    string $email,
    string $telefono,
    float $salarioBase,
    string $fechaNacimiento,
    string $fechaIngreso,
    string $fechaRetiro,
    string $profesion,
    string $fotografia,
    string $dpi,
    string $nit,
    string $irtra,
    string $igss,
    int $estado,
    int $codigoDepartamento,
    int $codigoUsuarioSistema,
    int $codigoJornadaLaboral,
    EmpleadoDAO $empleadoDao
) {
    try {
        $existe = $empleadoDao->validarExistenciaEmpleado($dpi);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
        if ($existe->Existe == 1) {
            http_response_code(409);
        } else {
            $result = $empleadoDao->guardarEmpleado(
                $nombres,
                $apellidos,
                $email,
                $telefono,
                $salarioBase,
                $fechaNacimiento,
                $fechaIngreso,
                $fechaRetiro,
                $profesion,
                $fotografia,
                $dpi,
                $nit,
                $irtra,
                $igss,
                $estado,
                $codigoDepartamento,
                $codigoUsuarioSistema,
                $codigoJornadaLaboral
            );
            if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
                /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }
}

function actualizarEmpleado(
    string $codigoEmpleado,
    string $nombres,
    string $apellidos,
    string $email,
    string $telefono,
    float $salarioBase,
    string $fechaNacimiento,
    string $fechaIngreso,
    string $fechaRetiro,
    string $profesion,
    string $fotografia,
    string $dpi,
    string $nit,
    string $irtra,
    string $igss,
    int $estado,
    int $codigoDepartamento,
    int $codigoUsuarioSistema,
    int $codigoJornadaLaboral,
    EmpleadoDAO $empleadoDao
) {
    try {
        $existe = $empleadoDao->validarExistenciaEmpleado($dpi);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
        if ($existe->Existe == 1 & $existe->CodigoEmpleado != $codigoEmpleado) {
            http_response_code(409);
        } else {
            $result = $empleadoDao->actualizarEmpleado(
                $codigoEmpleado,
                $nombres,
                $apellidos,
                $email,
                $telefono,
                $salarioBase,
                $fechaNacimiento,
                $fechaIngreso,
                $fechaRetiro,
                $profesion,
                $fotografia,
                $dpi,
                $nit,
                $irtra,
                $igss,
                $estado,
                $codigoDepartamento,
                $codigoUsuarioSistema,
                $codigoJornadaLaboral
            );
            if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
                /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }
}

?>