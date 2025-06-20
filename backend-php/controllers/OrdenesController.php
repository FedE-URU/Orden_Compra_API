<?php
// backend-php/controllers/OrdenesController.php

include_once '../config/database.php';
include_once '../models/Orden.php';
include_once '../models/Cliente.php';
include_once '../models/Producto.php';
include_once '../models/ItemOrden.php'; // Incluir la clase ItemOrden

class OrdenesController {
    private $db;
    private $orden;
    private $cliente;
    private $producto_model; // Para obtener detalles de productos

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->orden = new Orden($this->db);
        $this->cliente = new Cliente($this->db);
        $this->producto_model = new Producto($this->db);
    }

    public function createOrden($data) {
        // Validar que los datos no estén vacíos y tengan el formato esperado
        if (
            !isset($data->clienteId) ||
            !isset($data->nombreCliente) ||
            !isset($data->direccionCliente) ||
            !isset($data->montoPago) ||
            !isset($data->metodoPago) ||
            !isset($data->items) ||
            !is_array($data->items) ||
            empty($data->items)
        ) {
            http_response_code(400); // Bad Request
            echo json_encode(array("message" => "Datos incompletos o inválidos para la orden."));
            return;
        }

        // Buscar o crear el cliente (simplificado para el ejercicio)
        // En un escenario real, 'clienteId' debería ser validado contra un usuario autenticado
        // o si es un nuevo cliente, se debería crear uno.
        // Aquí asumimos que el clienteId es válido o lo usamos como placeholder.
        $this->cliente->id = $data->clienteId;
        $this->cliente->nombre = $data->nombreCliente;
        $this->cliente->direccion = $data->direccionCliente;

        // Si la lógica del modelo Cliente::readOrCreate se implementa para crear si no existe,
        // podrías llamarla aquí:
        // if (!$this->cliente->readOrCreate($data->nombreCliente, $data->direccionCliente)) {
        //     http_response_code(503);
        //     echo json_encode(array("message" => "No se pudo procesar la información del cliente."));
        //     return;
        // }


        $this->orden->cliente_id = $data->clienteId; // Usar el ID del cliente (existente o creado)
        $this->orden->monto_total = $data->montoPago;
        $this->orden->metodo_pago = $data->metodoPago;

        $orden_items_to_save = [];
        $calculated_total = 0; // Para verificar el total de la orden con los precios de la BD

        // Validar y procesar ítems
        foreach ($data->items as $item_data) {
            if (!isset($item_data->productoId) || !isset($item_data->cantidad) || $item_data->cantidad <= 0) {
                http_response_code(400);
                echo json_encode(array("message" => "Detalles de ítems de orden incompletos o inválidos."));
                return;
            }

            $item_producto_id = $item_data->productoId;
            $item_cantidad = $item_data->cantidad;

            // Obtener el precio unitario del producto desde la base de datos para asegurar integridad
            $this->producto_model->id = $item_producto_id;
            if ($this->producto_model->readOne()) {
                $precio_unitario = $this->producto_model->precio;
                $calculated_total += ($precio_unitario * $item_cantidad);

                $item_orden = new ItemOrden();
                $item_orden->producto_id = $item_producto_id;
                $item_orden->cantidad = $item_cantidad;
                $item_orden->precio_unitario = (float)$precio_unitario; // Asegurarse que el precio sea float
                $orden_items_to_save[] = $item_orden;
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(array("message" => "Producto con ID " . $item_producto_id . " no encontrado."));
                return;
            }
        }

        // Opcional: Validación estricta del monto total para evitar manipulaciones del cliente
        // Si hay una diferencia significativa entre el monto enviado y el calculado, se rechaza.
        if (abs($calculated_total - (float)$this->orden->monto_total) > 0.01) {
            http_response_code(400);
            echo json_encode(array("message" => "El monto total de la orden no coincide con los precios de los productos."));
            return;
        }


        // Intentar crear la orden
        if ($this->orden->create()) {
            // Si la orden principal se crea, guardar los ítems
            $this->orden->id = $this->db->lastInsertId(); // Asegurarse de tener el ID de la nueva orden

            if ($this->orden->saveItems($orden_items_to_save)) {
                http_response_code(201); // Created
                echo json_encode(array("message" => "Orden creada exitosamente.", "order_id" => $this->orden->id));
            } else {
                // Si falla al guardar los ítems, puedes considerar hacer un rollback de la orden
                // o manejar la situación según tu lógica de negocio.
                // Para simplificar, simplemente enviamos un error.
                http_response_code(503); // Service Unavailable
                echo json_encode(array("message" => "No se pudo guardar los ítems de la orden."));
            }
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode(array("message" => "No se pudo crear la orden."));
        }
    }
}
?>
