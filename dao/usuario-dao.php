<?php
require_once("../includes/db-connector.php");
class UsuarioDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = new MySQLConnector();
        $this->connection = $this->connection->getConnection();
    }

    public function listarUsuarios()
    {
        $query = "SELECT US.CodigoUsuarioSistema AS Codigo
                            , US.Email
                            , RO.Nombre AS Rol
                            , RO.CodigoRol
                    FROM `UsuarioSistema` AS US
                    INNER JOIN Rol AS RO ON RO.CodigoRol = US.CodigoRol
                    ORDER BY Codigo ASC";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarExistenciaUsuario(string $email)
    {
        $query = "SELECT COUNT(*) AS Existe FROM `UsuarioSistema` WHERE Email = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarUsuario(string $email, string $clave, int $rol)
    {
        $query = "INSERT INTO UsuarioSistema (Email, Clave, CodigoRol) VALUES(?, ?, ?)";
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
    public function eliminarUsuario(int $codigoUsuario)
    {
        $query = "DELETE FROM UsuarioSistema WHERE CodigoUsuarioSistema = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarRoles()
    {
        $query = "SELECT CodigoRol, Nombre, GestionaNomina, GestionaEmpleados, GestionaMenu, GestionaReportes, GestionaCaja, Asistencia
                FROM Rol
                ORDER BY CodigoRol ASC";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarRol(string $nombre, int $gestionaNomina, int $gestionaEmpleados, int $gestionaMenu, int $gestionaReportes,  int $gestionaCaja, int $asistencia){
        $query = "INSERT INTO Rol (Nombre, GestionaNomina, GestionaEmpleados, GestionaMenu, GestionaReportes, GestionaCaja, Asistencia) 
                    VALUES(?, ?, ?, ?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->bindParam(2, $gestionaNomina);
        $prpstmt->bindParam(3, $gestionaEmpleados);
        $prpstmt->bindParam(4, $gestionaMenu);
        $prpstmt->bindParam(5, $gestionaReportes);
        $prpstmt->bindParam(6, $gestionaCaja);
        $prpstmt->bindParam(7, $asistencia);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarRol(int $codigoRol, string $nombre, int $gestionaNomina, int $gestionaEmpleados, int $gestionaMenu, int $gestionaReportes, int $gestionaCaja, int $asistencia)
    {
        $query = "UPDATE Rol SET Nombre = ?, GestionaNomina = ?, GestionaEmpleados = ?, GestionaMenu = ?, GestionaReportes = ?, GestionaCaja = ?,  Asistencia = ?
                WHERE CodigoRol = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->bindParam(2, $gestionaNomina);
        $prpstmt->bindParam(3, $gestionaEmpleados);
        $prpstmt->bindParam(4, $gestionaMenu);
        $prpstmt->bindParam(5, $gestionaReportes);
        $prpstmt->bindParam(6, $gestionaCaja);
        $prpstmt->bindParam(7, $asistencia);
        $prpstmt->bindParam(8, $codigoRol);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function eliminarRol(int $codigoRol)
    {
        $query = "DELETE FROM Rol WHERE CodigoRol = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoRol);
        $prpstmt->execute();
        return $prpstmt;
    }

}
?>