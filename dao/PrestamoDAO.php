<?php
namespace dao;
use includes\MySQLConnector;
class PrestamoDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = MySQLConnector::getInstance();
        $this->connection = $this->connection->getConnection();
    }

    public function guardarPrestamo(string $fecha, float $monto, int $cuotas, string $codigoEmpleado)
    {
        $query = "call guardarPrestamo(?, ?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $fecha);
        $prpstmt->bindParam(2, $monto);
        $prpstmt->bindParam(3, $cuotas);
        $prpstmt->bindParam(4, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function listarPrestamosEmpleado(string $nombreEmpleado)
    {
        $query = "call listarPrestamosEmpleado(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombreEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarEmpleadoPrestamosPendientes(string $codigoEmpleado)
    {
        $query = "call validarEmpleadoPrestamosPendientes(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function listarPrestamos()
    {
        $query = "call listarPrestamos()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarPrestamo(int $codigoPrestamo)
    {
        $query = "call validarPrestamo(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoPrestamo);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarAbono(string $fecha, int $cuotas, int $codigoPrestamo)
    {
        $query = "call guardarAbono(?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $fecha);
        $prpstmt->bindParam(2, $cuotas);
        $prpstmt->bindParam(3, $codigoPrestamo);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarAbonosPrestamo(int $codigoAbono)
    {
        $query = "call listarAbonosPrestamo(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoAbono);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>