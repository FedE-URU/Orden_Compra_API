<?php
// backend-php/models/Orden.php

class Orden {
    private $conn;
    private $table_name = "ordenes";
    private $item_table_name = "orden_items";

    public $id;
    public $cliente_id;
    public $fecha_creacion;
    public $monto_total;
    public $metodo_pago;
    public $items; // Array de objetos ItemOrden

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una nueva orden
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (cliente_id, monto_total, metodo_pago) VALUES (:cliente_id, :monto_total, :metodo_pago)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":cliente_id", $this->cliente_id);
        $stmt->bindParam(":monto_total", $this->monto_total);
        $stmt->bindParam(":metodo_pago", $this->metodo_pago);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Guardar los ítems de la orden
    public function saveItems($items) {
        $success = true;
        foreach ($items as $item) {
            $query = "INSERT INTO " . $this->item_table_name . " (orden_id, producto_id, cantidad, precio_unitario) VALUES (:orden_id, :producto_id, :cantidad, :precio_unitario)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":orden_id", $this->id);
            $stmt->bindParam(":producto_id", $item->producto_id);
            $stmt->bindParam(":cantidad", $item->cantidad);
            $stmt->bindParam(":precio_unitario", $item->precio_unitario); // Asegúrate de que el precio unitario se envíe desde el frontend o se obtenga del producto

            if (!$stmt->execute()) {
                $success = false;
                break;
            }
        }
        return $success;
    }
}
?>
