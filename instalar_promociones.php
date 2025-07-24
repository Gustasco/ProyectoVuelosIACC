<?php
/**
 * Script para crear la tabla de promociones e insertar datos de prueba
 * Ejecuta las especificaciones del issue de @RudyC-90
 */

require_once 'conexion.php';

echo "=== Instalador de Base de Datos para Promociones ===\n";
echo "Basado en especificaciones del issue de @RudyC-90\n\n";

try {
    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
    
    echo "✅ Conexión a base de datos establecida\n";
    
    // Crear tabla promociones
    $sql_create_table = "
    CREATE TABLE IF NOT EXISTS promociones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(100) NOT NULL COMMENT 'Título de la promoción',
        descripcion TEXT COMMENT 'Descripción detallada de la promoción',
        imagen_url VARCHAR(255) COMMENT 'URL de la imagen promocional',
        descuento_porcentaje DECIMAL(5,2) COMMENT 'Porcentaje de descuento (ej: 25.00)',
        precio_desde DECIMAL(10,2) COMMENT 'Precio desde para mostrar en la promoción',
        fecha_inicio DATE NOT NULL COMMENT 'Fecha de inicio de vigencia',
        fecha_fin DATE NOT NULL COMMENT 'Fecha de fin de vigencia',
        condiciones TEXT COMMENT 'Términos y condiciones de la promoción',
        destino_relacionado VARCHAR(100) COMMENT 'Destino o país relacionado',
        categoria ENUM('vuelo', 'hotel', 'paquete', 'destino') DEFAULT 'vuelo' COMMENT 'Tipo de promoción',
        activa BOOLEAN DEFAULT TRUE COMMENT 'Si la promoción está activa',
        orden_prioridad INT DEFAULT 1 COMMENT 'Orden de prioridad para mostrar (1 = más alta)',
        clicks_totales INT DEFAULT 0 COMMENT 'Contador de clicks para analytics',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        INDEX idx_activa_vigencia (activa, fecha_inicio, fecha_fin),
        INDEX idx_orden (orden_prioridad),
        INDEX idx_categoria (categoria)
    ) ENGINE=InnoDB COMMENT='Tabla de promociones para carousel de página principal'";
    
    if ($conn->query($sql_create_table)) {
        echo "✅ Tabla 'promociones' creada/verificada correctamente\n";
    } else {
        throw new Exception("Error creando tabla: " . $conn->error);
    }
    
    // Verificar si ya hay datos
    $result = $conn->query("SELECT COUNT(*) as total FROM promociones");
    $row = $result->fetch_assoc();
    
    if ($row['total'] == 0) {
        echo "📝 Insertando datos de promociones...\n";
        
        // Insertar promociones de prueba
        $promociones = [
            [
                "Brasil - Aventura Tropical",
                "Descubre las maravillas de Brasil con 25% de descuento. Incluye Rio de Janeiro, Salvador de Bahía y las increíbles playas del nordeste brasileño.",
                "https://images.unsplash.com/photo-1544279180-ad53faa5eaae?w=800",
                25.00, 899.99, "2025-01-01", "2025-12-31",
                "Válido para reservas hasta el 31 de diciembre 2025. Sujeto a disponibilidad. No acumulable con otras promociones.",
                "Brasil", "destino", 1
            ],
            [
                "París Cultural - Arte y Gastronomía",
                "Sumérgete en la cultura parisina. Torre Eiffel, Louvre, Notre-Dame y la mejor gastronomía francesa te esperan.",
                "https://images.unsplash.com/photo-1502602898536-47ad22581b52?w=800",
                15.00, 1299.99, "2025-02-01", "2025-11-30",
                "Incluye tour guiado por los principales monumentos. Válido de lunes a viernes.",
                "Francia", "paquete", 2
            ],
            [
                "Japón Sakura Season",
                "Experimenta la magia de los cerezos en flor. Tokio, Kyoto y Osaka durante la temporada más hermosa del año.",
                "https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?w=800",
                20.00, 2199.99, "2025-03-15", "2025-05-15",
                "Temporada limitada. Incluye JR Pass de 7 días. Reserva anticipada requerida.",
                "Japón", "paquete", 3
            ],
            [
                "Europa Multi-Destino",
                "Descubre 5 países europeos en un solo viaje. Madrid, París, Roma, Amsterdam y Berlín con vuelos incluidos.",
                "https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=800",
                30.00, 1899.99, "2025-04-01", "2025-10-31",
                "Tour de 14 días. Incluye traslados entre ciudades. Alojamiento en hoteles 4 estrellas.",
                "Europa", "paquete", 4
            ],
            [
                "Cancún Todo Incluido",
                "Relájate en las playas del Caribe mexicano. Resort 5 estrellas con todo incluido y actividades acuáticas.",
                "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800",
                35.00, 1599.99, "2025-06-01", "2025-09-30",
                "Temporada de verano. Incluye snorkel, kayak y tour a ruinas mayas. Mínimo 7 noches.",
                "México", "hotel", 5
            ],
            [
                "Dubai Lujo y Modernidad",
                "Experimenta el lujo del desierto. Burj Khalifa, safari en el desierto y compras en los mejores malls.",
                "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800",
                18.00, 2499.99, "2025-01-15", "2025-12-15",
                "Incluye tours por la ciudad y safari en 4x4. Alojamiento en hotel 5 estrellas.",
                "Emiratos Árabes Unidos", "paquete", 6
            ]
        ];
        
        $sql_insert = "INSERT INTO promociones (
                        titulo, descripcion, imagen_url, descuento_porcentaje, 
                        precio_desde, fecha_inicio, fecha_fin, condiciones, 
                        destino_relacionado, categoria, orden_prioridad
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql_insert);
        
        foreach ($promociones as $promo) {
            $stmt->bind_param("sssddsssssi", 
                $promo[0], $promo[1], $promo[2], $promo[3], $promo[4], 
                $promo[5], $promo[6], $promo[7], $promo[8], $promo[9], $promo[10]
            );
            
            if ($stmt->execute()) {
                echo "  ✅ Insertada: " . $promo[0] . "\n";
            } else {
                echo "  ❌ Error insertando: " . $promo[0] . "\n";
            }
        }
        
        $stmt->close();
    } else {
        echo "⚠️  Ya existen " . $row['total'] . " promociones en la base de datos\n";
    }
    
    echo "\n=== Verificando instalación ===\n";
    
    // Verificar promociones activas
    $result = $conn->query("SELECT COUNT(*) as total FROM promociones WHERE activa = TRUE");
    $total = $result->fetch_assoc();
    echo "✅ Promociones activas: " . $total['total'] . "\n";
    
    // Verificar promociones vigentes
    $result = $conn->query("SELECT COUNT(*) as vigentes FROM promociones WHERE activa = TRUE AND CURDATE() BETWEEN fecha_inicio AND fecha_fin");
    $vigentes = $result->fetch_assoc();
    echo "🎯 Promociones vigentes (dentro de fechas): " . $vigentes['vigentes'] . "\n";
    
    // Mostrar las promociones activas (máximo 6 como especifica el issue)
    echo "\n=== Promociones Instaladas (máximo 6) ===\n";
    $result = $conn->query("SELECT titulo, descuento_porcentaje, destino_relacionado, fecha_inicio, fecha_fin FROM promociones WHERE activa = TRUE ORDER BY orden_prioridad LIMIT 6");
    
    while ($promo = $result->fetch_assoc()) {
        echo sprintf(
            "🎫 %s - %s%% OFF - %s (%s a %s)\n",
            $promo['titulo'],
            $promo['descuento_porcentaje'],
            $promo['destino_relacionado'],
            $promo['fecha_inicio'],
            $promo['fecha_fin']
        );
    }
    
    echo "\n✅ ¡Instalación completada exitosamente!\n";
    echo "🔗 Puedes probar la API en: http://localhost/agencia/promociones_api.php?activas=1\n";
    echo "🎯 Criteria del issue @RudyC-90 implementados:\n";
    echo "   - ✅ Máximo 6 promociones mostradas\n";
    echo "   - ✅ Base de datos para gestionar promociones\n";
    echo "   - ✅ Validación de promociones activas\n";
    echo "   - ✅ API para obtener promociones vigentes\n";
    
} catch (Exception $e) {
    echo "❌ Error durante la instalación: " . $e->getMessage() . "\n";
    echo "🔧 Verifica que XAMPP esté ejecutándose y la base de datos 'agencia_viajes' exista.\n";
}

// Cerrar conexión
$conn->close();
?>
