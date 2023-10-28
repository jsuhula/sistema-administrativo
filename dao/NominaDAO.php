<?php
namespace dao;

use includes\MySQLConnector;
class NominaDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = MySQLConnector::getInstance();
        $this->connection = $this->connection->getConnection();
    }

    public function calcularNominaSalario(string $fechaOperacion)
    {
        $query = "call calcularNominaSalario(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $fechaOperacion);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarHonorarios(string $fechaOperacion)
    {
        $query = "call guardarHonorarios(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $fechaOperacion);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function realizarAbonoPorNomina(string $fechaOperacion)
    {
        $query = "call realizarAbonoPorNomina(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $fechaOperacion);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarExisteReporteNominaSalario(string $fechaOperacion)
    {
        $query = "call validarExisteReporteNominaSalario(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $fechaOperacion);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function calcularNominaBonificacionAguinaldo()
    {
        $query = "call calcularNominaBonificacionAguinaldo()";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>
