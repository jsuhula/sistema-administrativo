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

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $option = isset($_GET['option']) ? filter_var($_GET['option'], FILTER_SANITIZE_NUMBER_INT) : 0;

        switch ($option) {
            case 1:
                $fechaOperacion = isset($_GET['fechaOperacion']) ? filter_var($_GET['fechaOperacion'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
                calcularNominaSalario($fechaOperacion, $nominaDao);
                break;
            case 2:
                $fechaOperacion = isset($_GET['fechaOperacion']) ? filter_var($_GET['fechaOperacion'], FILTER_SANITIZE_NUMBER_INT) : 0;
                $codigoTipoBonificacion = isset($_GET['codigoTipoBonificacion']) ? filter_var($_GET['codigoTipoBonificacion']) : 0;
                calcularPagoBonificacion($fechaOperacion, intval($codigoTipoBonificacion), $nominaDao);
                break;
            case 3:
                $fechaOperacion = isset($_GET['fechaOperacion']) ? filter_var($_GET['fechaOperacion'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
                informePagoBono14($fechaOperacion, $nominaDao);
                break;
            case 4:
                $fechaOperacion = isset($_GET['fechaOperacion']) ? filter_var($_GET['fechaOperacion'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
                informePagoAguinaldo($fechaOperacion, $nominaDao);
                break;
        }
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"));
        $option = filter_var($data->option, FILTER_SANITIZE_NUMBER_INT);

        switch ($option) {
            case 1:
                $fechaOperacion = $data->fechaOperacion;
                guardarNominaSalario($fechaOperacion, $nominaDao);
                break;
            case 2:
                $fechaOperacion = $data->fechaOperacion;
                $codigoTipoBonificacion = $data->codigoTipoBonificacion;
                guardarReporteBonificacion($fechaOperacion, intval($codigoTipoBonificacion), $nominaDao);
                break;
            case 3:
                $fechaOperacion = $data->fechaOperacion;
                validarExisteReporteNominaSalario($fechaOperacion, $nominaDao);
                break;
            default:
                break;
        }
    } else {
        http_response_code(400);
    }
}

function calcularNominaSalario(string $fechaOperacion, NominaDAO $nominaDao)
{

    try {
        $result = $nominaDao->calcularNominaSalario($fechaOperacion);

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

function guardarNominaSalario(string $fechaOperacion, NominaDAO $nominaDao)
{
    try {
        $result = $nominaDao->guardarHonorarios($fechaOperacion);

        if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }
}

function validarExisteReporteNominaSalario(string $fechaOperacion, NominaDAO $nominaDao)
{
    try {
        $result = $nominaDao->validarExisteReporteNominaSalario($fechaOperacion);

        if ($result->fetch(PDO::FETCH_OBJ)->Existe > 0) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }

}

function calcularPagoBonificacion(string $fechaOperacion, int $codigoTipoBonificacion, NominaDAO $nominaDao)
{

    try {
        if ($codigoTipoBonificacion == 1) {
            $result = $nominaDao->calcularPagoBono14($fechaOperacion);

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
        }else if ($codigoTipoBonificacion == 2){
            $result = $nominaDao->calcularPagoAguinaldo($fechaOperacion);

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
        }
    } catch (PDOException $ex) {
        http_response_code(500); // Error en el servidor
    }

}

function guardarReporteBonificacion(string $fechaOperacion, int $codigoTipoBonificacion, NominaDAO $nominaDao)
{
    try {
        $result = $nominaDao->guardarReportePagoBono($fechaOperacion, $codigoTipoBonificacion);
        if ($result->fetch(PDO::FETCH_OBJ)->afected > 0) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }
}

function informePagoBono14($fechaOperacion, $nominaDao)
{
    $result = $nominaDao->informePagoBono14($fechaOperacion);

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
}

function informePagoAguinaldo($fechaOperacion, $nominaDao)
{
    $result = $nominaDao->informePagoAguinaldo($fechaOperacion);

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
}
?>