<?php

use dao\DepartamentoDAO;

main();
function main()
{
    require_once('../dao/DepartamentoDAO.php');
    require_once('../includes/MySQLConnector.php');
    $departamentoDao = new DepartamentoDAO();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $option = isset($_GET['option']) ? filter_var($_GET['option'], FILTER_SANITIZE_NUMBER_INT) : 0;

        switch ($option) {
            case 1:
                obtenerDepartamentos($departamentoDao);
                break;
            case 2:
                obtenerComisiones($departamentoDao);
                break;
            default:
                break;
        }
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"));
        $option = $data->option;

        switch ($option) {
            case 1:
                $nombreDepartamento = $data->nombreDepartamento;
                $codigoComision = $data->codigoComision;
                $codigoEmpleado = $data->codigoJefe;
                guardarDepartamento($nombreDepartamento, intval($codigoComision), $codigoEmpleado, $departamentoDao);
                break;
            case 2:
                $codigoDepartamento = $data->codigoDepartamento;
                $nombreDepartamento = $data->nombreDepartamento;
                $codigoComision = $data->codigoComision;
                $codigoEmpleado = $data->codigoJefe;
                actualizarDepartamento($codigoDepartamento, $nombreDepartamento, $codigoComision, $codigoEmpleado, $departamentoDao);
                break;
            case 3:
                $codigoDepartamento = $data->codigoDepartamento;
                eliminarDepartamento(intval($codigoDepartamento), $departamentoDao);
                break;
            case 4:
                $codigoComision = $data->codigoComision;
                $nombreComision = $data->nombreComision;
                $restriccionesComision = $data->restriccionesComision;
                $bonoComision = $data->bonoComision;
                guardarComision($nombreComision, $restriccionesComision, floatval($bonoComision), $departamentoDao);
                break;
            case 5:
                $codigoComision = $data->codigoComision;
                $nombreComision = $data->nombreComision;
                $restriccionesComision = $data->restriccionesComision;
                $bonoComision = $data->bonoComision;
                actualizarComision($codigoComision, $nombreComision, $restriccionesComision, floatval($bonoComision), $departamentoDao);
                break;
            case 6:
                $codigoComision = $data->codigoComision;
                eliminarComision($codigoComision, $departamentoDao);
                break;
        }
    } else {
        http_response_code(400); // Solicitud incorrecta
    }
}

function obtenerDepartamentos(DepartamentoDAO $departamentoDao)
{

    try {
        $result = $departamentoDao->listarDepartamentos();

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

function guardarDepartamento(string $nombreDepartamento, int $codigoComision, string $codigoEmpleado, DepartamentoDAO $departamentoDao)
{

    try {
        $existe = $departamentoDao->validarExistenciaDepartamento($nombreDepartamento);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
        if ($existe->Existe == 1) {
            http_response_code(409);
        } else {
            $result = $departamentoDao->guardarDepartamento($nombreDepartamento, $codigoComision, $codigoEmpleado);
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

function actualizarDepartamento(int $codigoDepartamento, string $nombreDepartamento, int $codigoComision, string $codigoEmpleado, DepartamentoDAO $departamentoDao)
{

    try {
        $existe = $departamentoDao->validarExistenciaDepartamento($nombreDepartamento);
        $existe = $existe->fetch(PDO::FETCH_OBJ);

        if ($existe->Existe == 1 & $existe->CodigoDepartamento != $codigoDepartamento) {
            http_response_code(409);
        } else {
            $result = $departamentoDao->actualizarDepartamento($codigoDepartamento, $nombreDepartamento, $codigoComision, $codigoEmpleado);

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

function eliminarDepartamento(int $codigoDepartamento, DepartamentoDAO $departamentoDao)
{

    try {
        $result = $departamentoDao->eliminarDepartamento($codigoDepartamento);
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

function obtenerComisiones(DepartamentoDAO $departamentoDao)
{

    try {
        $result = $departamentoDao->listarComisiones();

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

function guardarComision(string $nombreComision, string $restricciones, float $bono, DepartamentoDAO $departamentoDao)
{

    try {
        $existe = $departamentoDao->validarExistenciaComision($nombreComision);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
        if ($existe->Existe == 1) {
            http_response_code(409);
        } else {
            $result = $departamentoDao->guardarComision($nombreComision, $restricciones, $bono);
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

function actualizarComision(int $codigoComision, string $nombreComision, string $restricciones, float $bono, DepartamentoDAO $departamentoDao)
{

    try {
        $existe = $departamentoDao->validarExistenciaComision($nombreComision);
        $existe = $existe->fetch(PDO::FETCH_OBJ);
        if ($existe->Existe == 1 & $existe->CodigoComision != $codigoComision) {
            http_response_code(409);
        } else {
            $result = $departamentoDao->actualizarComision($codigoComision, $nombreComision, $restricciones, $bono);
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

function eliminarComision(int $codigoComision, DepartamentoDAO $departamentoDao)
{

    try {
        $result = $departamentoDao->eliminarComision($codigoComision);
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