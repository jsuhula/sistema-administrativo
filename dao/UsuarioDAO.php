<?php
namespace dao;
use includes\MySQLConnector;
class UsuarioDAO
{
    private $connection;
    private $_key;

    function __construct()
    {
        $this->connection = MySQLConnector::getInstance();
        $this->connection = $this->connection->getConnection();
        $this->_key = new UsuarioAccessoDAO();
    }

    public function listarUsuarios()
    {
        $query = "call listarUsuarios()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarUsuariosBusqueda(string $usuarioBusqueda)
    {
        $query = "call listarUsuariosBusqueda(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $usuarioBusqueda);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarUsuariosPorAsignar()
    {
        $query = "call listarUsuariosPorAsignar()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }


    public function validarExistenciaUsuario(string $email)
    {
        $query = "call validarExistenciaUsuario(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarUsuario(string $email, string $clave, int $rol, string $dir)
    {
        $key = $this->_key->keyDecrypt($dir);
        $query = "call guardarUsuario(?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->bindParam(2, $clave);
        $prpstmt->bindParam(3, $rol);
        $prpstmt->bindParam(4, $key);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarUsuario(int $codigoUsuario, string $email, string $clave, int $rol, string $dir)
    {
        $key = $this->_key->keyDecrypt($dir);
        $query = "call actualizarUsuario(?, ?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->bindParam(2, $email);
        $prpstmt->bindParam(3, $clave);
        $prpstmt->bindParam(4, $rol);
        $prpstmt->bindParam(5, $key);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarUsuarioNoClave(int $codigoUsuario, string $email, int $rol, string $dir)
    {
        $key = $this->_key->keyDecrypt($dir);
        $query = "call actualizarUsuarioNoClave(?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->bindParam(2, $email);
        $prpstmt->bindParam(3, $rol);
        $prpstmt->bindParam(4, $key);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function eliminarUsuario(int $codigoUsuario)
    {
        $query = "call eliminarUsuario(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarRoles()
    {
        $query = "call listarRoles()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarRol(string $nombre, int $gestionaNomina, int $gestionaEmpleados, int $gestionaMenu, int $gestionaReportes, int $gestionaCaja, int $gestionaPrestamos)
    {
        $query = "call guardarRol(?, ?, ?, ?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->bindParam(2, $gestionaNomina);
        $prpstmt->bindParam(3, $gestionaEmpleados);
        $prpstmt->bindParam(4, $gestionaMenu);
        $prpstmt->bindParam(5, $gestionaReportes);
        $prpstmt->bindParam(6, $gestionaCaja);
        $prpstmt->bindParam(7, $gestionaPrestamos);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarExistenciaRol(string $nombre)
    {
        $query = "call validarExistenciaRol(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarRol(int $codigoRol, string $nombre, int $gestionaNomina, int $gestionaEmpleados, int $gestionaMenu, int $gestionaReportes, int $gestionaCaja, int $gestionaPrestamos)
    {
        $query = "call actualizarRol(?, ?, ?, ?, ?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoRol);
        $prpstmt->bindParam(2, $nombre);
        $prpstmt->bindParam(3, $gestionaNomina);
        $prpstmt->bindParam(4, $gestionaEmpleados);
        $prpstmt->bindParam(5, $gestionaMenu);
        $prpstmt->bindParam(6, $gestionaReportes);
        $prpstmt->bindParam(7, $gestionaCaja);
        $prpstmt->bindParam(8, $gestionaPrestamos);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function eliminarRol(int $codigoRol)
    {
        $query = "call eliminarRol(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoRol);
        $prpstmt->execute();
        return $prpstmt;
    }

}
?>