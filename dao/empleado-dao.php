<?php
require_once("../includes/db-connector.php");
class EmpleadoDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = MySQLConnector::getInstance();
        $this->connection = $this->connection->getConnection();
    }

    public function listarEmpleados(int $estado)
    {
        $query = "call listarEmpleados(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $estado);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function guardarEmpleado(
        string $nombres,
        string $apellidos,
        string $email,
        string $telefono,
        float $salarioBase,
        string $fechaNacimiento,
        string $fechaIngreso,
        string $fechaRetiro,
        string $profesion,
        string $fotografia,
        string $jornada,
        string $dpi,
        string $nit,
        string $irtra,
        string $igss,
        int $estado,
        int $codigoDepartamento,
        int $codigoUsuarioSistema
    ) {
        $query = "call guardarEmpleado(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $nombres);
        $prpstmt->bindParam(2, $apellidos);
        $prpstmt->bindParam(3, $email);
        $prpstmt->bindParam(4, $telefono);
        $prpstmt->bindParam(5, $salarioBase);
        $prpstmt->bindParam(6, $fechaNacimiento);
        $prpstmt->bindParam(7, $fechaIngreso);
        $prpstmt->bindParam(8, $fechaRetiro);
        $prpstmt->bindParam(9, $profesion);
        $prpstmt->bindParam(10, $fotografia);
        $prpstmt->bindParam(11, $jornada);
        $prpstmt->bindParam(12, $dpi);
        $prpstmt->bindParam(13, $nit);
        $prpstmt->bindParam(14, $irtra);
        $prpstmt->bindParam(15, $igss);
        $prpstmt->bindParam(16, $estado);
        $prpstmt->bindParam(17, $codigoDepartamento);
        $prpstmt->bindParam(18, $codigoUsuarioSistema);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function validarExistenciaEmpleado(string $dpi)
    {
        $query = "call validarExistenciaEmpleado(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $dpi);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function actualizarEmpleado(
        string $codigoEmpleado,
        string $nombres,
        string $apellidos,
        string $email,
        string $telefono,
        float $salarioBase,
        string $fechaNacimiento,
        string $fechaIngreso,
        string $fechaRetiro,
        string $profesion,
        string $fotografia,
        string $jornada,
        string $dpi,
        string $nit,
        string $irtra,
        string $igss,
        int $estado,
        int $codigoDepartamento,
        int $codigoUsuarioSistema
    ) {
        $query = "call actualizarEmpleado(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoEmpleado);
        $prpstmt->bindParam(2, $nombres);
        $prpstmt->bindParam(3, $apellidos);
        $prpstmt->bindParam(4, $email);
        $prpstmt->bindParam(5, $telefono);
        $prpstmt->bindParam(6, $salarioBase);
        $prpstmt->bindParam(7, $fechaNacimiento);
        $prpstmt->bindParam(8, $fechaIngreso);
        $prpstmt->bindParam(9, $fechaRetiro);
        $prpstmt->bindParam(10, $profesion);
        $prpstmt->bindParam(11, $fotografia);
        $prpstmt->bindParam(12, $jornada);
        $prpstmt->bindParam(13, $dpi);
        $prpstmt->bindParam(14, $nit);
        $prpstmt->bindParam(15, $irtra);
        $prpstmt->bindParam(16, $igss);
        $prpstmt->bindParam(17, $estado);
        $prpstmt->bindParam(18, $codigoDepartamento);
        $prpstmt->bindParam(19, $codigoUsuarioSistema);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function listarEmpleadosBusqueda(string $empleadoBusqueda, int $estado)
    {
        $query = "call listarEmpleadosBusqueda(?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $empleadoBusqueda);
        $prpstmt->bindParam(2, $estado);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function eliminarEmpleado(int $codigoEmpleado)
    {
        $query = "call eliminarEmpleado(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function obtenerEmpleado(string $codigoEmpleado){
        $query = "call obtenerEmpleado(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoEmpleado);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>