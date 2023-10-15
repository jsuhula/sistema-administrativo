<?php
require_once("../includes/db-connector.php");
class MarcajeDAO
{
    private $connection;

    function __construct()
    {
        $this->connection = new MySQLConnector();
        $this->connection = $this->connection->getConnection();
    }

    public function validarMarcaje(int $codigoUsuario)
    {
        $query = "call valdarMarcaje(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function marcarEntrada(int $codigoUsuario, $fechaHora)
    {
        $query = "call marcarEntrada(?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->bindParam(2, $fechaHora);
        $prpstmt->execute();
        return $prpstmt;
    }
    public function marcarSalida(int $codigoUsuario, $fechaHora)
    {
        $query = "call marcarSalida(?, ?)";
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

    public function listarMarcajesDeEmpleado(int $codigoUsuario)
    {
        $query = "call listarMarcajeDeEMpleado(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>