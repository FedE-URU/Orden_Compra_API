-- Creación de la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `ordenes_compra_db`;

-- Usar la base de datos
USE `ordenes_compra_db`;

-- Tabla de Productos
CREATE TABLE IF NOT EXISTS `productos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `precio` DECIMAL(10, 2) NOT NULL,
    `proveedor_id` INT
);

-- Tabla de Clientes (simplificada para este ejemplo)
CREATE TABLE IF NOT EXISTS `clientes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `direccion` TEXT NOT NULL
);

-- Tabla de Órdenes
CREATE TABLE IF NOT EXISTS `ordenes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `cliente_id` INT NOT NULL,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `monto_total` DECIMAL(10, 2) NOT NULL,
    `metodo_pago` VARCHAR(100) NOT NULL,
    FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`)
);

-- Tabla de Ítems de Orden
CREATE TABLE IF NOT EXISTS `orden_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `orden_id` INT NOT NULL,
    `producto_id` INT NOT NULL,
    `cantidad` INT NOT NULL,
    `precio_unitario` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`orden_id`) REFERENCES `ordenes`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`producto_id`) REFERENCES `productos`(`id`)
);

-- Insertar algunos datos de ejemplo en productos
INSERT INTO `productos` (`nombre`, `precio`, `proveedor_id`) VALUES
('Laptop Dell XPS 15', 1500.00, 1),
('Monitor curvo Samsung', 300.00, 2),
('Teclado mecánico RGB', 90.00, 1),
('Mouse inalámbrico Logitech', 45.00, 3),
('Webcam HD', 60.00, 2);

-- Insertar un cliente de ejemplo
INSERT INTO `clientes` (`nombre`, `direccion`) VALUES
('Juan Pérez', 'Calle Falsa 123, Ciudad Ejemplo');
