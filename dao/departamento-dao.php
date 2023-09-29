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
        $query = "";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->execute();
        return $prpstmt;
    }
}
?>