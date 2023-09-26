<?php
require_once("../dao/usuario-dao.php");
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user = new UserDAO();
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
} else {
    http_response_code(400); // Solicitud incorrecta
}

?>