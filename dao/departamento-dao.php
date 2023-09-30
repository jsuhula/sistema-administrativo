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
        $query = "SELECT 
                        D.CodigoDepartamento AS Codigo,
                        D.Nombre,
                        C.CodigoComision,
                        E.CodigoEmpleado
                    FROM Departamento AS D
                    INNER JOIN Comision AS C ON C.CodigoComision = D.CodigoComision
                    INNER JOIN Empleado AS E ON E.CodigoEmpleado = D.CodigoEmpleado";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function validarExistenciaDepartamento(string $nombre)
    {
        $query = "SELECT COUNT(*) AS Existe FROM Departamento WHERE Nombre = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function guardarDepartamento(string $nombre, string $codigoComision, int $codigoEmpleado)
    {
        $query = "INSERT INTO Departamento (Nombre, CodigoComision, CodigoEmpleado) VALUES(?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->bindParam(2, $codigoComision);
        $prpstmt->bindParam(3, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarDepartamento(int $codigoDepartamento, $nombre, $codigoComision, $codigoEmpleado)
    {
        $query = "UPDATE Departamento  SET Nombre = ?, CodigoComision = ?, CodigoEmpleado = ? WHERE CodigoDepartamento = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombre);
        $prpstmt->bindParam(2, $codigoComision);
        $prpstmt->bindParam(3, $codigoEmpleado);
        $prpstmt->bindParam(4, $codigoDepartamento);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function eliminarDepartamento(int $codigoDepartamento)
    {
        $query = "DELETE FROM Departamento  WHERE CodigoDepartamento = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoDepartamento);
        $prpstmt->execute();
        return $prpstmt;
    }

}
?>