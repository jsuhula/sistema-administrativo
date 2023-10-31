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
                $tipoBonificacion = isset($_GET['fechaOperacion']) ? filter_var($_GET['fechaOperacion'], FILTER_SANITIZE_NUMBER_INT) : 0;
                $fechaOperacion = $data->fechaOperacion;
                calcularPagoBono14($fechaOperacion, $nominaDao);
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
                validarExisteReporteNominaSalario($fechaOperacion, $nominaDao);
                break;
            default:
                break;
        }
    } else {
        http_response_code(400); // Solicitud incorrecta
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
            //$result = $nominaDao->realizarAbonoPorNomina($fechaOperacion);
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
        }else{
            http_response_code(400);
        }
    } catch (PDOException $ex) {
        http_response_code(500);
    }

}

function calcularPagoBono14(string $fechaOperacion, NominaDAO $nominaDao)
{

    try {

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
    } catch (PDOException $ex) {
        http_response_code(500); // Error en el servidor
    }

}

?>