-- ===================================================================
-- Script de Creación de Base de Datos - Sistema de Agencia de Viajes
-- ===================================================================
-- Autor: Gustasco
-- Fecha: Julio 2025
-- Descripción: Script completo para crear la base de datos del sistema
--              de gestión de agencia de viajes
-- ===================================================================

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS agencia_viajes 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Seleccionar la base de datos
USE agencia_viajes;

-- ===================================================================
-- TABLA: vuelo
-- Descripción: Almacena información de vuelos disponibles
-- ===================================================================
CREATE TABLE IF NOT EXISTS vuelo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    origen VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    hora_salida TIME NOT NULL,
    hora_llegada TIME NOT NULL,
    aerolinea VARCHAR(100) NOT NULL,
    numero_vuelo VARCHAR(20) NOT NULL UNIQUE,
    plazas_disponibles INT NOT NULL DEFAULT 0,
    plazas_totales INT NOT NULL DEFAULT 0,
    precio DECIMAL(10,2) NOT NULL,
    clase_servicio ENUM('economica', 'ejecutiva', 'primera') DEFAULT 'economica',
    estado ENUM('activo', 'cancelado', 'completo') DEFAULT 'activo',
    duracion_minutos INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Índices para optimizar búsquedas
    INDEX idx_origen_destino (origen, destino),
    INDEX idx_fecha (fecha),
    INDEX idx_precio (precio),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLA: hotel
-- Descripción: Almacena información de hoteles registrados
-- ===================================================================
CREATE TABLE IF NOT EXISTS hotel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    pais VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    categoria_estrellas INT CHECK (categoria_estrellas BETWEEN 1 AND 5),
    habitaciones_disponibles INT NOT NULL DEFAULT 0,
    habitaciones_totales INT NOT NULL DEFAULT 0,
    precio_noche DECIMAL(10,2) NOT NULL,
    tipo_habitacion ENUM('individual', 'doble', 'suite', 'familiar') DEFAULT 'doble',
    servicios TEXT, -- JSON o texto con servicios disponibles
    descripcion TEXT,
    estado ENUM('activo', 'inactivo', 'mantenimiento') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Índices para optimizar búsquedas
    INDEX idx_ciudad (ciudad),
    INDEX idx_precio (precio_noche),
    INDEX idx_categoria (categoria_estrellas),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLA: cliente
-- Descripción: Información de clientes registrados
-- ===================================================================
CREATE TABLE IF NOT EXISTS cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    documento_tipo ENUM('dni', 'pasaporte', 'cedula') NOT NULL,
    documento_numero VARCHAR(50) NOT NULL,
    fecha_nacimiento DATE,
    nacionalidad VARCHAR(50),
    direccion TEXT,
    ciudad VARCHAR(100),
    codigo_postal VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    
    -- Índices
    INDEX idx_email (email),
    INDEX idx_documento (documento_tipo, documento_numero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLA: reserva
-- Descripción: Registros de reservas realizadas
-- ===================================================================
CREATE TABLE IF NOT EXISTS reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_reserva VARCHAR(20) NOT NULL UNIQUE,
    cliente_id INT,
    tipo_reserva ENUM('vuelo', 'hotel', 'paquete') NOT NULL,
    
    -- Datos del cliente (temporal si no está registrado)
    cliente_nombre VARCHAR(100) NOT NULL,
    cliente_email VARCHAR(150) NOT NULL,
    cliente_telefono VARCHAR(20),
    cliente_documento VARCHAR(50),
    
    -- Referencias a servicios
    vuelo_id INT NULL,
    hotel_id INT NULL,
    
    -- Detalles de la reserva
    fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_viaje DATE NOT NULL,
    fecha_regreso DATE,
    numero_pasajeros INT NOT NULL DEFAULT 1,
    numero_habitaciones INT DEFAULT 1,
    
    -- Información financiera
    precio_total DECIMAL(10,2) NOT NULL,
    descuento DECIMAL(10,2) DEFAULT 0,
    impuestos DECIMAL(10,2) DEFAULT 0,
    precio_final DECIMAL(10,2) NOT NULL,
    
    -- Estado y seguimiento
    estado ENUM('pendiente', 'confirmada', 'pagada', 'cancelada', 'completada') DEFAULT 'pendiente',
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia', 'cheque') NULL,
    fecha_pago TIMESTAMP NULL,
    
    -- Observaciones
    observaciones TEXT,
    
    -- Timestamps
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Claves foráneas
    FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE SET NULL,
    FOREIGN KEY (vuelo_id) REFERENCES vuelo(id) ON DELETE SET NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE SET NULL,
    
    -- Índices
    INDEX idx_codigo_reserva (codigo_reserva),
    INDEX idx_cliente_email (cliente_email),
    INDEX idx_fecha_viaje (fecha_viaje),
    INDEX idx_estado (estado),
    INDEX idx_tipo_reserva (tipo_reserva)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- TABLA: reserva_detalle
-- Descripción: Detalles específicos de cada reserva
-- ===================================================================
CREATE TABLE IF NOT EXISTS reserva_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT NOT NULL,
    tipo_item ENUM('vuelo', 'hotel', 'servicio_extra') NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    fecha_servicio DATE,
    
    FOREIGN KEY (reserva_id) REFERENCES reserva(id) ON DELETE CASCADE,
    INDEX idx_reserva_id (reserva_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- INSERTAR DATOS DE PRUEBA
-- ===================================================================

-- Insertar vuelos de ejemplo
INSERT INTO vuelo (origen, destino, fecha, hora_salida, hora_llegada, aerolinea, numero_vuelo, plazas_disponibles, plazas_totales, precio, clase_servicio, duracion_minutos) VALUES
('Madrid', 'Barcelona', '2025-08-15', '08:00:00', '09:15:00', 'Iberia', 'IB3021', 45, 180, 89.99, 'economica', 75),
('Madrid', 'París', '2025-08-16', '10:30:00', '12:45:00', 'Air France', 'AF1148', 32, 200, 159.99, 'economica', 135),
('Barcelona', 'Roma', '2025-08-17', '14:20:00', '16:10:00', 'Vueling', 'VY6251', 28, 160, 124.99, 'economica', 110),
('Madrid', 'Londres', '2025-08-18', '16:45:00', '18:30:00', 'British Airways', 'BA460', 52, 220, 199.99, 'economica', 105),
('Sevilla', 'Ámsterdam', '2025-08-19', '07:15:00', '10:30:00', 'KLM', 'KL1672', 38, 180, 179.99, 'economica', 195),
('Valencia', 'Milán', '2025-08-20', '12:00:00', '14:30:00', 'Ryanair', 'FR4729', 41, 189, 94.99, 'economica', 150),
('Madrid', 'Frankfurt', '2025-08-21', '09:30:00', '12:15:00', 'Lufthansa', 'LH1110', 29, 200, 189.99, 'economica', 165),
('Barcelona', 'Zurich', '2025-08-22', '15:10:00', '17:00:00', 'Swiss', 'LX1952', 35, 150, 169.99, 'economica', 110);

-- Insertar hoteles de ejemplo
INSERT INTO hotel (nombre, ciudad, pais, direccion, telefono, email, categoria_estrellas, habitaciones_disponibles, habitaciones_totales, precio_noche, tipo_habitacion, servicios, descripcion) VALUES
('Hotel Ritz Madrid', 'Madrid', 'España', 'Plaza de la Lealtad, 5, 28014 Madrid', '+34 91 701 67 67', 'reservas@ritz.madrid', 5, 12, 167, 450.00, 'suite', 'WiFi, Spa, Restaurante, Gimnasio, Servicio de habitaciones', 'Hotel de lujo en el corazón de Madrid'),
('Hotel Arts Barcelona', 'Barcelona', 'España', 'Marina 19-21, 08005 Barcelona', '+34 93 221 10 00', 'info@hotelartsbarcelona.com', 5, 8, 455, 380.00, 'doble', 'WiFi, Piscina, Spa, Restaurante, Vista al mar', 'Hotel icónico frente al mar en Barcelona'),
('Hotel Hassler Roma', 'Roma', 'Italia', 'Piazza Trinità dei Monti, 6, 00187 Roma', '+39 06 699 340', 'booking@hotelhasslerroma.com', 5, 15, 87, 520.00, 'suite', 'WiFi, Restaurante, Terraza, Servicio de conserjería', 'Hotel histórico en la cima de la escalinata española'),
('The Savoy London', 'Londres', 'Reino Unido', 'Strand, London WC2R 0EZ', '+44 20 7836 4343', 'info@the-savoy.co.uk', 5, 6, 267, 650.00, 'suite', 'WiFi, Spa, Múltiples restaurantes, Servicio de mayordomo', 'Hotel legendario en el corazón de Londres'),
('Hotel Casa Fuster', 'Barcelona', 'España', 'Passeig de Gràcia, 132, 08008 Barcelona', '+34 93 255 30 00', 'reservas@hotelcasafuster.com', 5, 20, 96, 295.00, 'doble', 'WiFi, Terraza, Restaurante, Ubicación privilegiada', 'Hotel modernista en Passeig de Gràcia'),
('Hotel Villa Magna', 'Madrid', 'España', 'Paseo de la Castellana, 22, 28046 Madrid', '+34 91 587 12 34', 'reservas@villamagna.es', 5, 18, 150, 385.00, 'doble', 'WiFi, Spa, Restaurante, Gimnasio, Business center', 'Elegancia y sofisticación en Madrid'),
('Hotel Iberostar Las Letras', 'Madrid', 'España', 'Gran Vía, 11, 28013 Madrid', '+34 91 523 79 80', 'madrid@iberostar.com', 4, 25, 109, 189.00, 'doble', 'WiFi, Restaurante, Terraza, Ubicación céntrica', 'Hotel boutique en Gran Vía'),
('Hotel Barcelona Princess', 'Barcelona', 'España', 'Avinguda Diagonal, 1, 08019 Barcelona', '+34 93 356 15 00', 'info@barcelona-princess.com', 4, 30, 363, 145.00, 'doble', 'WiFi, Piscina, Gimnasio, Centro de negocios', 'Hotel moderno cerca del mar');

-- Insertar clientes de ejemplo
INSERT INTO cliente (nombre, apellido, email, telefono, documento_tipo, documento_numero, fecha_nacimiento, nacionalidad, ciudad) VALUES
('Juan', 'García Pérez', 'juan.garcia@email.com', '+34 666 123 456', 'dni', '12345678A', '1985-03-15', 'Española', 'Madrid'),
('María', 'López Martín', 'maria.lopez@email.com', '+34 677 987 654', 'dni', '87654321B', '1990-07-22', 'Española', 'Barcelona'),
('Carlos', 'Rodríguez Silva', 'carlos.rodriguez@email.com', '+34 688 456 789', 'dni', '45678912C', '1988-11-08', 'Española', 'Sevilla'),
('Ana', 'Fernández Costa', 'ana.fernandez@email.com', '+34 699 321 654', 'dni', '78912345D', '1992-05-14', 'Española', 'Valencia'),
('Pedro', 'Sánchez Ruiz', 'pedro.sanchez@email.com', '+34 655 789 123', 'dni', '32165498E', '1987-09-30', 'Española', 'Bilbao');

-- Insertar reservas de ejemplo
INSERT INTO reserva (codigo_reserva, cliente_id, tipo_reserva, cliente_nombre, cliente_email, cliente_telefono, cliente_documento, vuelo_id, hotel_id, fecha_viaje, numero_pasajeros, precio_total, precio_final, estado) VALUES
('RES001', 1, 'vuelo', 'Juan García Pérez', 'juan.garcia@email.com', '+34 666 123 456', '12345678A', 1, NULL, '2025-08-15', 2, 179.98, 179.98, 'confirmada'),
('RES002', 2, 'hotel', 'María López Martín', 'maria.lopez@email.com', '+34 677 987 654', '87654321B', NULL, 2, '2025-08-20', 2, 760.00, 760.00, 'pendiente'),
('RES003', 3, 'paquete', 'Carlos Rodríguez Silva', 'carlos.rodriguez@email.com', '+34 688 456 789', '45678912C', 3, 3, '2025-08-17', 1, 644.99, 644.99, 'confirmada'),
('RES004', 4, 'vuelo', 'Ana Fernández Costa', 'ana.fernandez@email.com', '+34 699 321 654', '78912345D', 4, NULL, '2025-08-18', 1, 199.99, 199.99, 'pagada'),
('RES005', 5, 'hotel', 'Pedro Sánchez Ruiz', 'pedro.sanchez@email.com', '+34 655 789 123', '32165498E', NULL, 1, '2025-08-25', 2, 900.00, 900.00, 'confirmada');

-- ===================================================================
-- PROCEDIMIENTOS ALMACENADOS ÚTILES
-- ===================================================================

-- Procedimiento para generar código de reserva único
DELIMITER //
CREATE PROCEDURE GenerarCodigoReserva(OUT nuevo_codigo VARCHAR(20))
BEGIN
    DECLARE codigo_base VARCHAR(20);
    DECLARE contador INT DEFAULT 1;
    DECLARE existe INT DEFAULT 1;
    
    SET codigo_base = CONCAT('RES', DATE_FORMAT(NOW(), '%Y%m%d'));
    
    WHILE existe > 0 DO
        SET nuevo_codigo = CONCAT(codigo_base, LPAD(contador, 3, '0'));
        SELECT COUNT(*) INTO existe FROM reserva WHERE codigo_reserva = nuevo_codigo;
        SET contador = contador + 1;
    END WHILE;
END //
DELIMITER ;

-- ===================================================================
-- VISTAS ÚTILES
-- ===================================================================

-- Vista para vuelos disponibles con información completa
CREATE VIEW vista_vuelos_disponibles AS
SELECT 
    v.id,
    v.origen,
    v.destino,
    v.fecha,
    v.hora_salida,
    v.hora_llegada,
    v.aerolinea,
    v.numero_vuelo,
    v.plazas_disponibles,
    v.precio,
    v.clase_servicio,
    CONCAT(v.duracion_minutos DIV 60, 'h ', v.duracion_minutos MOD 60, 'm') AS duracion_formateada
FROM vuelo v
WHERE v.estado = 'activo' 
  AND v.fecha >= CURDATE()
  AND v.plazas_disponibles > 0
ORDER BY v.fecha, v.hora_salida;

-- Vista para hoteles disponibles
CREATE VIEW vista_hoteles_disponibles AS
SELECT 
    h.id,
    h.nombre,
    h.ciudad,
    h.pais,
    h.categoria_estrellas,
    h.habitaciones_disponibles,
    h.precio_noche,
    h.tipo_habitacion,
    h.servicios
FROM hotel h
WHERE h.estado = 'activo' 
  AND h.habitaciones_disponibles > 0
ORDER BY h.ciudad, h.categoria_estrellas DESC;

-- Vista para resumen de reservas
CREATE VIEW vista_resumen_reservas AS
SELECT 
    r.codigo_reserva,
    r.cliente_nombre,
    r.cliente_email,
    r.tipo_reserva,
    r.fecha_viaje,
    r.numero_pasajeros,
    r.precio_final,
    r.estado,
    v.origen AS vuelo_origen,
    v.destino AS vuelo_destino,
    h.nombre AS hotel_nombre,
    h.ciudad AS hotel_ciudad
FROM reserva r
LEFT JOIN vuelo v ON r.vuelo_id = v.id
LEFT JOIN hotel h ON r.hotel_id = h.id
ORDER BY r.fecha_reserva DESC;

-- ===================================================================
-- ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- ===================================================================

-- Índices compuestos para consultas comunes
CREATE INDEX idx_vuelo_busqueda ON vuelo(origen, destino, fecha, estado);
CREATE INDEX idx_hotel_busqueda ON hotel(ciudad, categoria_estrellas, estado);
CREATE INDEX idx_reserva_cliente ON reserva(cliente_email, estado);

-- ===================================================================
-- CONFIGURACIÓN DE PRIVILEGIOS (Opcional)
-- ===================================================================

-- Crear usuario para la aplicación (opcional)
-- CREATE USER 'agencia_user'@'localhost' IDENTIFIED BY 'agencia_pass123';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON agencia_viajes.* TO 'agencia_user'@'localhost';
-- FLUSH PRIVILEGES;

-- ===================================================================
-- SCRIPT COMPLETADO
-- ===================================================================

SELECT 'Base de datos agencia_viajes creada exitosamente!' AS mensaje;
SELECT COUNT(*) AS total_vuelos FROM vuelo;
SELECT COUNT(*) AS total_hoteles FROM hotel;
SELECT COUNT(*) AS total_clientes FROM cliente;
SELECT COUNT(*) AS total_reservas FROM reserva;
