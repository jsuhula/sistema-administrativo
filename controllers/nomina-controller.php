<?php

session_start();
use dao\NominaDAO;

if (!$_SESSION) {
    header('location: ../login.php');
}

main();
function main()
{
    require_once('../dao/NominaDAO.php');
    require_once('../includes/MySQLConnector.php');
    $nominaDao = new NominaDAO();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"));
        $option = filter_var($data->option, FILTER_SANITIZE_NUMBER_INT);

        switch ($option) {
            case 1:
                $fecha = $data->fecha;
                calcularNomina($fecha, $nominaDao);
                break;
            case 2:
                $fecha = $data->fecha;
                guardarNomina($fecha);
                break;
            case 3:
                break;
        }
    } else {
        http_response_code(400); // Solicitud incorrecta
    }
}

function calcularNomina(string $fecha, NominaDAO $nominaDao)
{

    try {
        $result = $nominaDao->calculoNominaSalario($fecha);

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

function guardarNomina(string $fecha, NominaDAO $nominaDao)
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

?>