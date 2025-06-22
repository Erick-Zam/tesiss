-- Script para crear la tabla detalle_producto usando datos de productos o detalle_envio
-- Este script es opcional y no es necesario ejecutarlo si has decidido usar las tablas existentes

-- Crear la tabla detalle_producto si no existe
CREATE TABLE IF NOT EXISTS `detalle_producto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `proveedor_id` int DEFAULT NULL,
  `fecha_cosecha` date NOT NULL,
  `fecha_envio` date NOT NULL,
  `lote` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Insertar datos desde la tabla productos (si la tabla detalle_producto está vacía)
INSERT INTO `detalle_producto` (cantidad, precio, tipo, proveedor_id, fecha_cosecha, fecha_envio, lote)
SELECT p.cantidad, p.precio, p.tipo, p.proveedor_id, p.fecha_cosecha, p.fecha_envio, p.lote
FROM productos p
WHERE NOT EXISTS (SELECT 1 FROM detalle_producto);

-- Opción alternativa: Si prefieres usar datos de detalle_envio en lugar de productos
-- Descomenta las siguientes líneas y comenta las anteriores

-- INSERT INTO `detalle_producto` (cantidad, precio, tipo, proveedor_id, fecha_cosecha, fecha_envio, lote)
-- SELECT 
--     100 as cantidad, -- valor por defecto para cantidad
--     1000 as precio, -- valor por defecto para precio
--     'Arroz' as tipo, -- valor por defecto para tipo
--     de.proveedor_id,
--     de.fecha_cosecha,
--     de.fecha_envio,
--     de.lote
-- FROM detalle_envio de 
-- WHERE NOT EXISTS (SELECT 1 FROM detalle_producto);
