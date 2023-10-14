<?php
session_start();
use dao\UsuarioAccessoDAO;


if(!$_SESSION){
    if (main() != 0) {
        $_SESSION['CodigoUsuario'] = main();
        header('Content-Type: application/json');
        echo json_encode(1);
    }
}else{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = json_decode(file_get_contents("php://input"));
        $salir = filter_var($data->salir, FILTER_SANITIZE_EMAIL);
        if ($salir == 1) {
            $_SESSION['CodigoUsuario'] = null;
            session_destroy();
            header('Content-Type: application/json');
            echo json_encode(1);
        }
    }
}

function main(): int
{
    require_once('../dao/UsuarioAccessoDAO.php');
    require_once('../includes/MySQLConnector.php');
    $usuarioAccesoDao = new UsuarioAccessoDAO();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"));
        $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        $clave = filter_var($data->clave, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($email) || empty($clave)) {
            header('Content-Type: application/json');
            echo json_encode(0);
        } else {
            try {
                $usuario = $usuarioAccesoDao->validarCredenciales($email, $clave, "../");
                $usuario = $usuario->fetch(PDO::FETCH_OBJ);

                if ($usuario->Existe == 1) {
                    return $usuario->CodigoUsuario;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(-1);
                }
            } catch (PDOException $ex) {
                http_response_code(500);
            }
        }

    }
    return 0;
}

?>