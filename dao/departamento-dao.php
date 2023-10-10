<?php
require_once("../includes/db-connector.php");
class DepartamentoDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = new MySQLConnector();
        $this->connection = $this->connection->getConnection();
    }

    public function listarDepartamentos()
    {
        $query = "call listarDepartamentos()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarExistenciaDepartamento(string $nombre)
    {
        $query = "call validarExistenciaDepartamento(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarDepartamento(string $nombre, int $codigoComision, string $codigoEmpleado)
    {
        $query = "call guardarDepartamento(?,?,?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->bindParam(2, $codigoComision);
        $prpstmt->bindParam(3, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarDepartamento(int $codigoDepartamento, $nombre, $codigoComision, $codigoEmpleado)
    {
        $query = "call actualizarDepartamento(?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoDepartamento);
        $prpstmt->bindParam(2, $nombre);
        $prpstmt->bindParam(3, $codigoComision);
        $prpstmt->bindParam(4, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function eliminarDepartamento(int $codigoDepartamento)
    {
        $query = "call eliminarDepartamento(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoDepartamento);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarComisiones()
    {
        $query = "call listarComisiones()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarComision(string $nombreComision, string $restricciones, float $bono)
    {
        $query = "call guardarComision(?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombreComision);
        $prpstmt->bindParam(2, $restricciones);
        $prpstmt->bindParam(3, $bono);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarComision(int $codigoComision, string $nombreComision, string $restricciones, float $bono)
    {
        $query = "call actualizarComision(?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoComision);
        $prpstmt->bindParam(2, $nombreComision);
        $prpstmt->bindParam(3, $restricciones);
        $prpstmt->bindParam(4, $bono);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarExistenciaComision(string $nombreComision)
    {
        $query = "call validarExistenciaComision(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombreComision);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function eliminarComision(int $codigoComision)
    {
        $query = "call eliminarComision(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoComision);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>