<?php
require_once("../includes/db-connector.php");
class EmpleadoDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = new MySQLConnector();
        $this->connection = $this->connection->getConnection();
    }

    public function listarEmpleados()
    {
        $query = "SELECT 
                        E.CodigoEmpleado,
                        Nombres,
                        Apellidos,
                        CONCAT(Nombres, ' ', Apellidos) AS NombreCompleto,
                        Email,
                        Telefono,
                        SalarioBase,
                        FechaNacimiento,
                        FechaIngreso,
                        FechaRetiro,
                        Profesion,
                        Fotografia,
                        DPI,
                        NIT,
                        IRTRA,
                        IGSS,
                        Estado,
                        D.Nombre AS Departamento,
                        CodigoUsuarioSistema,
                        CodigoJornadaLaboral,
                        D.CodigoDepartamento
                    FROM Empleado AS E
                    INNER JOIN Departamento AS D ON D.CodigoDepartamento = E.CodigoDepartamento";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>