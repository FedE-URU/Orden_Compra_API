<?php
// backend-php/models/Producto.php

class Producto {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $nombre;
    public $precio;
    public $proveedor_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los productos
    public function read() {
        $query = "SELECT id, nombre, precio, proveedor_id FROM " . $this->table_name . " ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un producto por ID
    public function readOne() {
        $query = "SELECT id, nombre, precio, proveedor_id FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->nombre = $row['nombre'];
            $this->precio = $row['precio'];
            $this->proveedor_id = $row['proveedor_id'];
            return true;
        }
        return false;
    }
}
?>
