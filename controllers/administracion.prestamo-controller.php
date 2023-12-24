<?php

session_start();
if (!$_SESSION) {
  header('location: ../login.php');
}

use dao\PrestamoDAO;

main();
function main()
{
    require_once('../dao/PrestamoDAO.php');
    require_once('../includes/MySQLConnector.php');
    $prestamoDao = new PrestamoDAO();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $option = isset($_GET['option']) ? filter_var($_GET['option'], FILTER_SANITIZE_NUMBER_INT) : 0;
        $nombreEmpleado = isset($_GET['nombreEmpleado']) ? filter_var($_GET['nombreEmpleado'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";

        switch ($option) {
            case 1:
                if(empty($nombreEmpleado)){
                    obtenerPrestamos($prestamoDao);
                }else{
                    buscarPrestamosEmpleado($nombreEmpleado, $prestamoDao);
                }
                
                break;
            case 2:
                $codigoPrestamo = isset($_GET['codigoPrestamo']) ? filter_var($_GET['codigoPrestamo'], FILTER_SANITIZE_NUMBER_INT) : 0;
                validarPrestamo(intval($codigoPrestamo), $prestamoDao);
                break;
            default:
            break;
        }
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"));
        $option = $data->option;

        switch ($option) {
            case 1:
                $fecha = $data->fecha;
                $monto = $data->monto;
                $cuotas = $data->cuotas;
                $codigoEmpleado = $data->codigoEmpleado;
                guardarPrestamo($fecha, floatval($monto), intval($cuotas), $codigoEmpleado, $prestamoDao);
                break;
            case 2:
                $fecha = $data->fecha;
                $codigoPrestamo = $data->codigoPrestamo;
                $cuotas = $data->cuotas;
                guardarAbono($fecha, intval($cuotas),  $codigoPrestamo, $prestamoDao);
                break;
            case 3:
                $codigoPrestamo = $data->codigoPrestamo;
                obtenerAbonosPrestamo($codigoPrestamo, $prestamoDao);
                break;
        }
    } else {
        http_response_code(400); // Solicitud incorrecta
    }
}

function obtenerPrestamos(PrestamoDAO $prestamoDao)
{

    try {
        $result = $prestamoDao->listarPrestamos();

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
            http_response_code(400); //
        }
    } catch (PDOException $ex) {
        http_response_code(500); // Error en el servidor
    }

}

function guardarPrestamo(string $fecha, float $monto, int $cuotas, string $codigoEmpleado, PrestamoDAO $prestamoDao)
{

    try {

        if (validarPrestamosPendientes($codigoEmpleado, $prestamoDao) == 0) {
            $result = $prestamoDao->guardarPrestamo($fecha, $monto, $cuotas, $codigoEmpleado);
            if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
                /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }else{
            http_response_code(401);
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }

}

function validarPrestamosPendientes(string $codigoEmpleado, PrestamoDAO $prestamoDao)
{
    try {
        $existePrestamo = $prestamoDao->validarEmpleadoPrestamosPendientes($codigoEmpleado);
        if ($existePrestamo->rowCount() > 0) {
            if ($existePrestamo->fetch(PDO::FETCH_OBJ)->SaldoPendiente == 0) {
                return 0;
            }
            return 1;
        }
        return 0;
    } catch (PDOException $ex) {
        print_r($ex);
    }
}
function buscarPrestamosEmpleado(string $nombreEmpleado, PrestamoDAO $prestamoDao)
{

    try {
        $result = $prestamoDao->listarPrestamosEmpleado($nombreEmpleado);

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
            http_response_code(400); //
        }
    } catch (PDOException $ex) {
        http_response_code(500); // Error en el servidor
    }

}

function validarPrestamo(string $codigoPrestamo, PrestamoDAO $prestamoDao)
{

    try {
        $result = $prestamoDao->validarPrestamo($codigoPrestamo);

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
            http_response_code(400); //
        }
    } catch (PDOException $ex) {
        http_response_code(500); // Error en el servidor
    }

}

function obtenerAbonosPrestamo(int $codigoPrestamo, PrestamoDAO $prestamoDao)
{

    try {
        $result = $prestamoDao->listarAbonosPrestamo($codigoPrestamo);

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
            http_response_code(400);
        }
    } catch (PDOException $ex) {
        http_response_code(500); // Error en el servidor
    }

}

function guardarAbono(string $fecha, int $cuotas, int $codigoPrestamo, PrestamoDAO $prestamoDao)
{

    try {
        $result = $prestamoDao->guardarAbono($fecha, $cuotas, $codigoPrestamo);
        if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
            /* SE LE RESPONDE CON EL CODIGO 200 QUE INDICA PETICION EXITOSA */
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }

}
?>