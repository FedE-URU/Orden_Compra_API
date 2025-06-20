<?php
// backend-php/models/Cliente.php

class Cliente {
    private $conn;
    private $table_name = "clientes";

    public $id;
    public $nombre;
    public $direccion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener un cliente por ID (o crear uno si no existe, simplificado)
    public function readOrCreate($nombre, $direccion) {
        // Intentar buscar por nombre y dirección (simplificado, en un caso real se buscaría por ID o email)
        $query = "SELECT id, nombre, direccion FROM " . $this->table_name . " WHERE nombre = ? AND direccion = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $direccion);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->direccion = $row['direccion'];
            return true;
        } else {
            // Si no existe, crear uno nuevo (simplificado para el ejercicio)
            $query = "INSERT INTO " . $this->table_name . " (nombre, direccion) VALUES (:nombre, :direccion)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':direccion', $direccion);

            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                $this->nombre = $nombre;
                $this->direccion = $direccion;
                return true;
            }
        }
        return false;
    }
}
?>
