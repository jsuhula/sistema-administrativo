<?php
namespace dao;

use DateTime;
use includes\MySQLConnector;
class MarcajeDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = MySQLConnector::getInstance();
        $this->connection = $this->connection->getConnection();
    }

    public function validarAsistencia(int $codigoUsuario, string $fecha)
    {
        $query = "call validarAsistencia(?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->bindParam(2, $fecha);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function asistenciaEntrada(int $codigoUsuario, string $fechaHora)
    {
        $query = "call asistenciaEntrada(?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->bindParam(2, $fechaHora);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function asistenciaSalida(int $codigoUsuario, string $fechaHora)
    {
        $query = "call asistenciaSalida(?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->bindParam(2, $fechaHora);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listMarcajes()
    {
        $query = "call listarMarcajes()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>