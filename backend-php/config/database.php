<?php
// backend-php/config/database.php

class Database {
    private $host = "localhost";
    private $db_name = "ordenes_compra_db";
    private $username = "root"; // Cambia si tu usuario de MySQL es diferente
    private $password = "";     // Cambia si tu contraseña de MySQL es diferente
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión a la base de datos: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
