<?php

namespace dao;
use includes\MySQLConnector;
class UsuarioAccessoDAO
{
    private $connection;
    function __construct()
    {
        $this->connection = MySQLConnector::getInstance();
        $this->connection = $this->connection->getConnection();
    }

    public function validarCredenciales(string $email, string $clave, string $dir)
    {
        $key = $this->keyDecrypt($dir);
        $query = "call validarCredenciales(?, ?, ?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $email);
        $prpstmt->bindParam(2, $clave);
        $prpstmt->bindParam(3, $key);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function obtenerDatosDeSesion(int $codigoUsuario)
    {
        $query = "call obtenerDatosDeSesion(?)";
        $prpstmt = $this->connection->prepare($query);
        $prpstmt->bindParam(1, $codigoUsuario);
        $prpstmt->execute();
        return $prpstmt;
    }

    public function keyDecrypt(string $dir): string
    {
        $_DIR_ROOT = str_replace('\\', "/", "");
        $_dir = $_DIR_ROOT .$dir .'includes/';
        $_keyEnc = $_dir . '_key.bin';
        $_cif = file_get_contents($_keyEnc);
        $_auxKey = 0x5A;
        $_keyDec = "";

        foreach (str_split($_cif) as $byte) {
            $_keyDec .= chr(ord($byte) ^ $_auxKey);
        }

        return $_keyDec;
    }
}