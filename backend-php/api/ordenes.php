<?php
// backend-php/api/ordenes.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET"); // Permitir POST y GET
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Orden.php';
include_once '../models/Cliente.php';
include_once '../models/Producto.php'; // Para obtener precio unitario si no viene del frontend

$database = new Database();
$db = $database->getConnection();

$orden = new Orden($db);
$cliente = new Cliente($db);
$producto_model = new Producto($db); // Para obtener precios

// Obtener los datos enviados por el frontend
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->clienteId) &&
    !empty($data->nombreCliente) &&
    !empty($data->direccionCliente) &&
    !empty($data->montoPago) &&
    !empty($data->metodoPago) &&
    !empty($data->items) &&
    is_array($data->items)
) {
    // Buscar o crear el cliente
    $cliente->id = $data->clienteId;
    $cliente->nombre = $data->nombreCliente;
    $cliente->direccion = $data->direccionCliente;

    // Nota: Para un sistema real, deberías validar o crear el cliente en la BD
    // aquí estamos asumiendo que el clienteId es válido o que se maneja la creación implícitamente
    // Simplificamos la lógica del cliente para este ejercicio, asumiendo que el clienteId ya existe
    // o que el frontend envía un clienteId fijo para pruebas.
    // Si necesitas crear el cliente si no existe, la lógica de Cliente::readOrCreate es útil.
    // Por ahora, asumamos que el cliente con ese ID ya existe o es un placeholder.
    // Opcional: Podrías buscar el cliente por ID y si no existe, crearlo.

    $orden->cliente_id = $data->clienteId;
    $orden->monto_total = $data->montoPago;
    $orden->metodo_pago = $data->metodoPago;

    if ($orden->create()) {
        $orden_items_to_save = [];
        $total_verificado = 0; // Para verificar el total de la orden con los precios de la BD

        foreach ($data->items as $item_data) {
            $item_producto_id = $item_data->productoId;
            $item_cantidad = $item_data->cantidad;

            // Obtener el precio unitario del producto desde la base de datos
            $producto_model->id = $item_producto_id;
            if ($producto_model->readOne()) {
                $precio_unitario = $producto_model->precio;
                $total_verificado += ($precio_unitario * $item_cantidad);

                $item_orden = new ItemOrden();
                $item_orden->producto_id = $item_producto_id;
                $item_orden->cantidad = $item_cantidad;
                $item_orden->precio_unitario = $precio_unitario;
                $orden_items_to_save[] = $item_orden;
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Producto con ID " . $item_producto_id . " no encontrado."));
                return;
            }
        }

        // Puedes añadir una verificación más robusta del monto total
        // if (abs($total_verificado - $orden->monto_total) > 0.01) {
        //     http_response_code(400);
        //     echo json_encode(array("message" => "Monto total no coincide con los ítems."));
        //     // Opcional: borrar la orden creada si falla la validación
        //     return;
        // }

        if ($orden->saveItems($orden_items_to_save)) {
            http_response_code(201);
            echo json_encode(array("message" => "Orden creada exitosamente.", "order_id" => $orden->id));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "No se pudo guardar los ítems de la orden."));
        }
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear la orden."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos o inválidos para la orden."));
}
?>
