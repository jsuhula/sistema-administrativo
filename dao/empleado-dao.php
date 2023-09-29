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
                        CodigoEmpleado,
                        Nombres,
                        Apellidos,
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

    public function guardarEmpleado(string $email, string $clave, int $rol)
    {
        $query = "INSERT INTO UsuarioSistema (Email, Clave, CodigoRol) VALUES(?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->bindParam(2, $clave);
        $prpstmt->bindParam(3, $rol);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function actualizarEmpleado(int $codigoUsuarioSistema, $email, $clave, $rol)
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
    public function eliminarEmpleado(int $codigoEmpleado)
    {
        $query = "DELETE FROM Empleado WHERE CodigoEmpleado = ?";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }

}
?>