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
    public function ingresarEmpleado(string $nombre, string $correo)
    {
        $query = "INSERT INTO usuarios(nombre, correo) VALUES(?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->bindParam(2, $correo);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function listarEmpleados(){
        $query = "SELECT * FROM Empleado";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function listarUsuarios(){
        $query = "SELECT US.CodigoUsuarioSistema AS Codigo
                            , US.Email
                            , RO.Nombre AS Rol
                            , RO.GestionaNomina AS Nomina
                            , RO.GestionaEmpleados AS Empleados
                            , RO.GestionaMenu AS Menu
                            , RO.GestionaReportes AS Reportes
                            , RO.GestionaCaja AS Caja
                    FROM `UsuarioSistema` AS US
                    INNER JOIN Rol AS RO ON RO.CodigoRol = US.CodigoRol";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }
}

?>