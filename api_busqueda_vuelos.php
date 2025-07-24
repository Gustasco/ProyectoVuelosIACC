<?php
include 'conexion.php';
header('Content-Type: application/json');

// Verificar que la conexión a la base de datos sea exitosa
if (!$conexion) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener parámetros de búsqueda
$origen = isset($_GET['origen']) ? trim($_GET['origen']) : '';
$destino = isset($_GET['destino']) ? trim($_GET['destino']) : '';
$fecha_ida = isset($_GET['fecha_ida']) ? $_GET['fecha_ida'] : '';
$fecha_vuelta = isset($_GET['fecha_vuelta']) ? $_GET['fecha_vuelta'] : '';
$pasajeros = isset($_GET['pasajeros']) ? (int)$_GET['pasajeros'] : 1;
$clase = isset($_GET['clase']) ? $_GET['clase'] : 'economica';
$precio_min = isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : 999999;

// Construir consulta SQL base
$sql = "SELECT 
            v.id_vuelo,
            v.origen,
            v.destino,
            v.fecha_salida,
            v.hora_salida,
            v.fecha_llegada,
            v.hora_llegada,
            v.precio,
            v.aerolinea,
            v.numero_vuelo,
            v.disponibilidad,
            v.duracion_estimada
        FROM vuelo v 
        WHERE v.disponibilidad > 0";

$params = [];
$types = "";

// Agregar filtros según los parámetros recibidos
if (!empty($origen)) {
    $sql .= " AND LOWER(v.origen) LIKE LOWER(?)";
    $params[] = "%$origen%";
    $types .= "s";
}

if (!empty($destino)) {
    $sql .= " AND LOWER(v.destino) LIKE LOWER(?)";
    $params[] = "%$destino%";
    $types .= "s";
}

if (!empty($fecha_ida)) {
    $sql .= " AND v.fecha_salida >= ?";
    $params[] = $fecha_ida;
    $types .= "s";
}

if ($precio_min > 0) {
    $sql .= " AND v.precio >= ?";
    $params[] = $precio_min;
    $types .= "d";
}

if ($precio_max < 999999) {
    $sql .= " AND v.precio <= ?";
    $params[] = $precio_max;
    $types .= "d";
}

// Filtrar por disponibilidad según número de pasajeros
if ($pasajeros > 1) {
    $sql .= " AND v.disponibilidad >= ?";
    $params[] = $pasajeros;
    $types .= "i";
}

// Ordenar resultados
$sql .= " ORDER BY v.precio ASC, v.fecha_salida ASC";

try {
    // Preparar y ejecutar consulta
    if (!empty($params)) {
        $stmt = $conexion->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }
    } else {
        $resultado = $conexion->query($sql);
    }

    if (!$resultado) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }

    $vuelos = [];
    while ($fila = $resultado->fetch_assoc()) {
        // Calcular duración si no está disponible
        if (empty($fila['duracion_estimada'])) {
            $salida = new DateTime($fila['fecha_salida'] . ' ' . $fila['hora_salida']);
            $llegada = new DateTime($fila['fecha_llegada'] . ' ' . $fila['hora_llegada']);
            $duracion = $salida->diff($llegada);
            $fila['duracion_estimada'] = $duracion->format('%hh %im');
        }

        // Formatear datos para el frontend
        $vuelo = [
            'id' => (int)$fila['id_vuelo'],
            'aerolinea' => $fila['aerolinea'],
            'numero_vuelo' => $fila['numero_vuelo'],
            'origen' => $fila['origen'],
            'destino' => $fila['destino'],
            'fecha_salida' => $fila['fecha_salida'],
            'hora_salida' => substr($fila['hora_salida'], 0, 5), // HH:MM format
            'fecha_llegada' => $fila['fecha_llegada'],
            'hora_llegada' => substr($fila['hora_llegada'], 0, 5), // HH:MM format
            'duracion' => $fila['duracion_estimada'],
            'precio' => (float)$fila['precio'],
            'disponibilidad' => (int)$fila['disponibilidad'],
            'clase' => $clase,
            'directo' => true, // Simplificación - en una implementación real se verificaría
            'equipaje' => true // Simplificación - en una implementación real se verificaría
        ];

        $vuelos[] = $vuelo;
    }

    // Estadísticas de búsqueda
    $stats = [
        'total_resultados' => count($vuelos),
        'precio_minimo' => !empty($vuelos) ? min(array_column($vuelos, 'precio')) : 0,
        'precio_maximo' => !empty($vuelos) ? max(array_column($vuelos, 'precio')) : 0,
        'precio_promedio' => !empty($vuelos) ? round(array_sum(array_column($vuelos, 'precio')) / count($vuelos), 2) : 0
    ];

    // Respuesta exitosa
    $respuesta = [
        'success' => true,
        'vuelos' => $vuelos,
        'estadisticas' => $stats,
        'parametros_busqueda' => [
            'origen' => $origen,
            'destino' => $destino,
            'fecha_ida' => $fecha_ida,
            'fecha_vuelta' => $fecha_vuelta,
            'pasajeros' => $pasajeros,
            'clase' => $clase,
            'precio_min' => $precio_min,
            'precio_max' => $precio_max
        ]
    ];

    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    // Manejo de errores
    $error_response = [
        'success' => false,
        'error' => $e->getMessage(),
        'codigo_error' => 'SEARCH_ERROR'
    ];
    
    echo json_encode($error_response, JSON_UNESCAPED_UNICODE);
}

// Cerrar conexión
if (isset($stmt)) {
    $stmt->close();
}
$conexion->close();
?>
