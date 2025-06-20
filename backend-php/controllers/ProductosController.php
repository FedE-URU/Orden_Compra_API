<?php
// backend-php/controllers/ProductosController.php

include_once '../config/database.php';
include_once '../models/Producto.php';

class ProductosController {
    private $db;
    private $producto;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    public function getProductos() {
        $stmt = $this->producto->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $productos_arr = array();
            $productos_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // `extract($row)` convierte las claves del array en variables.
                // Es útil pero se debe usar con cuidado para evitar colisiones de nombres.
                extract($row);
                $producto_item = array(
                    "productId" => $id,
                    "nombre" => $nombre,
                    "precio" => (float)$precio, // Asegurarse que el precio sea un float
                    "proveedorId" => $proveedor_id
                );
                array_push($productos_arr["records"], $producto_item);
            }

            http_response_code(200); // OK
            echo json_encode($productos_arr);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(array("message" => "No se encontraron productos."));
        }
    }

    // Si tuvieras un endpoint para obtener un solo producto, podrías tener un método así:
    // public function getProductoById($id) {
    //     $this->producto->id = $id;
    //     if ($this->producto->readOne()) {
    //         $producto_item = array(
    //             "productId" => $this->producto->id,
    //             "nombre" => $this->producto->nombre,
    //             "precio" => (float)$this->producto->precio,
    //             "proveedorId" => $this->producto->proveedor_id
    //         );
    //         http_response_code(200);
    //         echo json_encode($producto_item);
    //     } else {
    //         http_response_code(404);
    //         echo json_encode(array("message" => "Producto no encontrado."));
    //     }
    // }
}
?>
