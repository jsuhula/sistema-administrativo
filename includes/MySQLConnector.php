<?php
namespace includes;
use PDO;
USE PDOException;
class MySQLConnector {
    private static $instance;
    private $connector;
    private $server = "localhost";
    private $dbname = "deaquisoy";
    private $user = "root";
    private $passwd = "";

    private function __construct() {
        try {
            $this->connector = new PDO("mysql:host={$this->server};dbname={$this->dbname}", $this->user, $this->passwd);
            $this->connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            throw new PDOException("Error de conexión, contáctese con soporte. Detalles -> ERR: " . $ex->getMessage());
        }
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self(); 
        }
        return self::$instance;
    }
    public function __clone() {}
    public function __wakeup() {}
    public function getConnection(): PDO {
        return $this->connector;
    }
}

?>