<?php
/**
 * Script para insertar datos de prueba en la tabla promociones
 * Ejecutar una sola vez para tener promociones de prueba
 */

require_once 'conexion.php';

// Crear tabla si no existe
$sql_create_table = "CREATE TABLE IF NOT EXISTS promociones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    imagen_url VARCHAR(500),
    descuento_porcentaje DECIMAL(5,2) DEFAULT 0,
    precio_desde DECIMAL(10,2) DEFAULT 0,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    condiciones TEXT,
    destino_relacionado VARCHAR(255),
    categoria VARCHAR(100),
    orden_prioridad INT DEFAULT 999,
    activa BOOLEAN DEFAULT TRUE,
    clicks_totales INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create_table)) {
    echo "✅ Tabla promociones verificada/creada correctamente\n";
} else {
    die("❌ Error creando tabla: " . $conn->error);
}

// Verificar si ya hay datos
$check_data = $conn->query("SELECT COUNT(*) as count FROM promociones WHERE activa = TRUE");
$existing = $check_data->fetch_assoc()['count'];

if ($existing > 0) {
    echo "ℹ️ Ya existen {$existing} promociones activas. Actualizando...\n";
    // Desactivar promociones existentes para evitar duplicados
    $conn->query("UPDATE promociones SET activa = FALSE WHERE activa = TRUE");
}

// Datos de promociones de prueba con URLs de imágenes válidas
$promociones_prueba = [
    [
        'titulo' => 'Europa Multi-Destino',
        'descripcion' => 'Descubre 5 países europeos en un solo viaje. Madrid, París, Roma, Amsterdam y Berlín con vuelos incluidos. Una experiencia única que te llevará por lo mejor de Europa en 15 días inolvidables.',
        'imagen_url' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=600&h=400&fit=crop',
        'descuento_porcentaje' => 30.00,
        'precio_desde' => 1899.99,
        'fecha_inicio' => date('Y-m-d'),
        'fecha_fin' => date('Y-m-d', strtotime('+2 months')),
        'condiciones' => 'Válido para reservas hasta fin de mes. Incluye vuelos, hoteles 4* y desayunos. No incluye visados ni seguro de viaje.',
        'destino_relacionado' => 'Europa',
        'categoria' => 'cultural',
        'orden_prioridad' => 1
    ],
    [
        'titulo' => 'Caribe Todo Incluido',
        'descripcion' => 'Relájate en las mejores playas del Caribe. Cancún, Punta Cana y Jamaica te esperan con resorts de lujo y actividades acuáticas ilimitadas.',
        'imagen_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop',
        'descuento_porcentaje' => 25.00,
        'precio_desde' => 2299.99,
        'fecha_inicio' => date('Y-m-d'),
        'fecha_fin' => date('Y-m-d', strtotime('+1 month')),
        'condiciones' => 'Todo incluido: comidas, bebidas, actividades. Mínimo 7 noches. Sujeto a disponibilidad.',
        'destino_relacionado' => 'Caribe',
        'categoria' => 'playa',
        'orden_prioridad' => 2
    ],
    [
        'titulo' => 'Japón Tradicional',
        'descripcion' => 'Sumérgete en la cultura japonesa. Tokio, Kioto y Osaka con experiencias auténticas: ceremonia del té, templos, jardines zen y la mejor gastronomía.',
        'imagen_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600&h=400&fit=crop',
        'descuento_porcentaje' => 20.00,
        'precio_desde' => 3499.99,
        'fecha_inicio' => date('Y-m-d'),
        'fecha_fin' => date('Y-m-d', strtotime('+3 months')),
        'condiciones' => 'Incluye guía especializado, JR Pass y hoteles tradicionales. Grupos máximo 12 personas.',
        'destino_relacionado' => 'Japón',
        'categoria' => 'cultural',
        'orden_prioridad' => 3
    ],
    [
        'titulo' => 'Aventura en Patagonia',
        'descripcion' => 'Explora los paisajes más espectaculares del mundo. Torres del Paine, Glaciar Perito Moreno y El Calafate en una aventura épica.',
        'imagen_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600&h=400&fit=crop',
        'descuento_porcentaje' => 15.00,
        'precio_desde' => 2799.99,
        'fecha_inicio' => date('Y-m-d'),
        'fecha_fin' => date('Y-m-d', strtotime('+45 days')),
        'condiciones' => 'Incluye trekking guiado, equipo especializado y alojamiento en refugios. Nivel físico intermedio requerido.',
        'destino_relacionado' => 'Patagonia',
        'categoria' => 'aventura',
        'orden_prioridad' => 4
    ],
    [
        'titulo' => 'Tailandia Exótica',
        'descripcion' => 'Bangkok, Chiang Mai y las islas Phi Phi. Templos dorados, playas paradisíacas, mercados flotantes y la hospitalidad tailandesa.',
        'imagen_url' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=600&h=400&fit=crop',
        'descuento_porcentaje' => 35.00,
        'precio_desde' => 1599.99,
        'fecha_inicio' => date('Y-m-d'),
        'fecha_fin' => date('Y-m-d', strtotime('+60 days')),
        'condiciones' => 'Temporada alta incluida. Vuelos con Qatar Airways. Hoteles boutique seleccionados.',
        'destino_relacionado' => 'Tailandia',
        'categoria' => 'exotico',
        'orden_prioridad' => 5
    ],
    [
        'titulo' => 'Safari Africano',
        'descripcion' => 'Kenya y Tanzania: experimenta la gran migración, los Big Five y las culturas masai en un safari fotográfico único.',
        'imagen_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&h=400&fit=crop',
        'descuento_porcentaje' => 40.00,
        'precio_desde' => 3999.99,
        'fecha_inicio' => date('Y-m-d'),
        'fecha_fin' => date('Y-m-d', strtotime('+30 days')),
        'condiciones' => 'Temporada migración incluida. Lodges de lujo. Guía especializado en vida salvaje. Seguro médico incluido.',
        'destino_relacionado' => 'África',
        'categoria' => 'safari',
        'orden_prioridad' => 6
    ]
];

// Insertar promociones
$stmt = $conn->prepare("INSERT INTO promociones (
    titulo, descripcion, imagen_url, descuento_porcentaje, precio_desde, 
    fecha_inicio, fecha_fin, condiciones, destino_relacionado, categoria, 
    orden_prioridad, activa, clicks_totales
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, TRUE, ?)");

$insertados = 0;
foreach ($promociones_prueba as $promocion) {
    $clicks_random = rand(0, 150); // Clicks aleatorios para realismo
    
    $stmt->bind_param("sssddsssssii",
        $promocion['titulo'],
        $promocion['descripcion'],
        $promocion['imagen_url'],
        $promocion['descuento_porcentaje'],
        $promocion['precio_desde'],
        $promocion['fecha_inicio'],
        $promocion['fecha_fin'],
        $promocion['condiciones'],
        $promocion['destino_relacionado'],
        $promocion['categoria'],
        $promocion['orden_prioridad'],
        $clicks_random
    );
    
    if ($stmt->execute()) {
        $insertados++;
        echo "✅ Promoción '{$promocion['titulo']}' insertada correctamente\n";
    } else {
        echo "❌ Error insertando '{$promocion['titulo']}': " . $stmt->error . "\n";
    }
}

$stmt->close();
echo "\n🎉 Proceso completado: {$insertados} promociones insertadas/actualizadas\n";
echo "🔗 Ahora puedes visitar promociones_dinamicas.html para ver el carousel funcionando\n";
echo "📊 API endpoint: promociones_api.php?activas=1\n";
?>
