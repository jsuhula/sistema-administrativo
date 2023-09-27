<?php
require_once("../includes/db-connector.php");
class UserDAO
{
    private $connection;
    function __construct()
    {
        $this->connection = new MySQLConnector();
        $this->connection = $this->connection->getConnection();
    }
    public function guardarUsuario(string $email, string $clave, int $rol)
    {
        $query = "call spRegistrarUsuario (?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->bindParam(2, $clave);
        $prpstmt->bindParam(3, $rol);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function actualizarUsuario(int $codigoUsuarioSistema, $email, $clave, $rol)
    {
        $query = "UPDATE UsuarioSistema SET Email = ?, Clave = ?, CodigoRol = ? WHERE CodigoUsuarioSistema = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->bindParam(2, $clave);
        $prpstmt->bindParam(3, $rol);
        $prpstmt->bindParam(4, $codigoUsuarioSistema);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function actualizarUsuarioNoClave(int $codigoUsuarioSistema, $email, $rol)
    {
        $query = "UPDATE UsuarioSistema SET Email = ?, CodigoRol = ? WHERE CodigoUsuarioSistema = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->bindParam(2, $rol);
        $prpstmt->bindParam(3, $codigoUsuarioSistema);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function eliminarUsuario(int $codigoUsuarioSistema)
    {
        $query = "DELETE FROM UsuarioSistema WHERE CodigoUsuarioSistema = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuarioSistema);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function listarUsuarios()
    {
        $query = "SELECT US.CodigoUsuarioSistema AS Codigo
                            , US.Email
                            , RO.Nombre AS Rol
                            , RO.CodigoRol
                    FROM `UsuarioSistema` AS US
                    INNER JOIN Rol AS RO ON RO.CodigoRol = US.CodigoRol";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarRoles()
    {
        $query = "SELECT CodigoRol
                        , Nombre
                        , GestionaNomina
                        , GestionaEmpleados
                        , GestionaMenu
                        , GestionaReportes
                        , GestionaCaja
                        , Asistencia
                   FROM Rol";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

}

?>