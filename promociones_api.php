<?php
/**
 * API REST para gestión de promociones del carousel
 * Basada en los criterios especificados en el issue de @RudyC-90
 * 
 * Endpoints:
 * GET /promociones_api.php?activas=1 - Obtener promociones vigentes (máximo 6)
 * GET /promociones_api.php?click=1&id=X - Registrar click para analytics
 * POST /promociones_api.php - Crear nueva promoción (admin)
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Manejar preflight requests
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'conexion.php';

class PromocionesAPI {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
        
        // Verificar conexión
        if ($this->conexion->connect_error) {
            throw new Exception("Error de conexión: " . $this->conexion->connect_error);
        }
    }
    
    /**
     * Obtener promociones activas (máximo 6 como especifica el issue)
     */
    public function obtenerPromocionesActivas() {
        try {
            $sql = "SELECT 
                        id, 
                        titulo, 
                        descripcion, 
                        imagen_url, 
                        descuento_porcentaje, 
                        precio_desde,
                        fecha_inicio, 
                        fecha_fin, 
                        condiciones, 
                        destino_relacionado, 
                        categoria,
                        clicks_totales
                    FROM promociones 
                    WHERE activa = TRUE 
                    AND CURDATE() BETWEEN fecha_inicio AND fecha_fin 
                    ORDER BY orden_prioridad ASC 
                    LIMIT 6";
            
            $result = $this->conexion->query($sql);
            
            if (!$result) {
                throw new Exception("Error en la consulta: " . $this->conexion->error);
            }
            
            $promociones = [];
            while ($row = $result->fetch_assoc()) {
                // Formatear datos para el frontend
                $row['descuento_porcentaje'] = floatval($row['descuento_porcentaje']);
                $row['precio_desde'] = floatval($row['precio_desde']);
                $row['clicks_totales'] = intval($row['clicks_totales']);
                $row['vigente'] = $this->verificarVigencia(
                    $row['fecha_inicio'], 
                    $row['fecha_fin']
                );
                $promociones[] = $row;
            }
            
            return [
                'success' => true,
                'data' => $promociones,
                'total' => count($promociones),
                'timestamp' => date('c'),
                'criteria' => [
                    'max_promociones' => 6,
                    'autoplay_segundos' => 5,
                    'implementado_por' => '@Gustasco',
                    'issue_origen' => '@RudyC-90'
                ]
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Error al obtener promociones',
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Registrar click en promoción para analytics
     */
    public function registrarClick($id) {
        try {
            $id = intval($id);
            $sql = "UPDATE promociones 
                    SET clicks_totales = clicks_totales + 1 
                    WHERE id = ? AND activa = TRUE";
            
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparando consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            
            if (!$result) {
                throw new Exception("Error ejecutando consulta: " . $stmt->error);
            }
            
            $affected_rows = $stmt->affected_rows;
            $stmt->close();
            
            return [
                'success' => true,
                'message' => 'Click registrado correctamente',
                'promocion_id' => $id,
                'affected_rows' => $affected_rows,
                'timestamp' => date('c')
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Error al registrar click',
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Crear nueva promoción (para panel admin futuro)
     */
    public function crearPromocion($datos) {
        try {
            $errores = $this->validarDatosPromocion($datos);
            if (!empty($errores)) {
                return [
                    'success' => false,
                    'error' => 'Datos de promoción no válidos',
                    'errores' => $errores
                ];
            }
            
            $sql = "INSERT INTO promociones (
                        titulo, descripcion, imagen_url, descuento_porcentaje, 
                        precio_desde, fecha_inicio, fecha_fin, condiciones, 
                        destino_relacionado, categoria, orden_prioridad
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparando consulta: " . $this->conexion->error);
            }
            
            $orden_prioridad = isset($datos['orden_prioridad']) ? intval($datos['orden_prioridad']) : 999;
            
            $stmt->bind_param("sssddsssssi",
                $datos['titulo'],
                $datos['descripcion'],
                $datos['imagen_url'],
                $datos['descuento_porcentaje'],
                $datos['precio_desde'],
                $datos['fecha_inicio'],
                $datos['fecha_fin'],
                $datos['condiciones'],
                $datos['destino_relacionado'],
                $datos['categoria'],
                $orden_prioridad
            );
            
            $result = $stmt->execute();
            
            if (!$result) {
                throw new Exception("Error ejecutando consulta: " . $stmt->error);
            }
            
            $insert_id = $this->conexion->insert_id;
            $stmt->close();
            
            return [
                'success' => true,
                'id' => $insert_id,
                'message' => 'Promoción creada correctamente',
                'timestamp' => date('c')
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Error al crear promoción',
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Verificar si una promoción está vigente
     */
    private function verificarVigencia($fecha_inicio, $fecha_fin) {
        $hoy = date('Y-m-d');
        return ($hoy >= $fecha_inicio && $hoy <= $fecha_fin);
    }
    
    /**
     * Validar datos de promoción
     */
    private function validarDatosPromocion($datos) {
        $errores = [];
        
        if (empty($datos['titulo'])) {
            $errores[] = 'El título es requerido';
        }
        
        if (empty($datos['fecha_inicio']) || empty($datos['fecha_fin'])) {
            $errores[] = 'Las fechas de inicio y fin son requeridas';
        }
        
        if (!empty($datos['fecha_inicio']) && !empty($datos['fecha_fin'])) {
            if (strtotime($datos['fecha_inicio']) > strtotime($datos['fecha_fin'])) {
                $errores[] = 'La fecha de inicio no puede ser posterior a la fecha de fin';
            }
        }
        
        if (!empty($datos['descuento_porcentaje'])) {
            if ($datos['descuento_porcentaje'] < 0 || $datos['descuento_porcentaje'] > 100) {
                $errores[] = 'El descuento debe estar entre 0 y 100';
            }
        }
        
        return $errores;
    }
}

// Procesar petición
try {
    $api = new PromocionesAPI($conn);
    $method = $_SERVER['REQUEST_METHOD'];
    $response = [];

    switch ($method) {
        case 'GET':
            if (isset($_GET['activas'])) {
                $response = $api->obtenerPromocionesActivas();
            } elseif (isset($_GET['click']) && isset($_GET['id'])) {
                $response = $api->registrarClick($_GET['id']);
            } else {
                $response = [
                    'success' => false,
                    'error' => 'Parámetro no válido',
                    'info' => [
                        'title' => 'API de Promociones - Agencia de Viajes',
                        'version' => '1.0',
                        'implementado_por' => '@Gustasco',
                        'basado_en_issue' => '@RudyC-90'
                    ],
                    'endpoints' => [
                        'GET ?activas=1' => 'Obtener promociones vigentes (máximo 6)',
                        'GET ?click=1&id=X' => 'Registrar click en promoción',
                        'POST con JSON' => 'Crear nueva promoción (admin)'
                    ],
                    'criterios_implementados' => [
                        'max_6_promociones' => true,
                        'autoplay_5_segundos' => true,
                        'click_tracking' => true,
                        'validacion_fechas' => true,
                        'api_rest' => true
                    ]
                ];
            }
            break;
            
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            if ($input) {
                $response = $api->crearPromocion($input);
            } else {
                $response = [
                    'success' => false,
                    'error' => 'Datos JSON no válidos',
                    'example' => [
                        'titulo' => 'Promoción Ejemplo',
                        'descripcion' => 'Descripción de la promoción',
                        'imagen_url' => 'https://ejemplo.com/imagen.jpg',
                        'descuento_porcentaje' => 25.00,
                        'precio_desde' => 599.99,
                        'fecha_inicio' => '2025-01-01',
                        'fecha_fin' => '2025-12-31',
                        'condiciones' => 'Términos y condiciones',
                        'destino_relacionado' => 'España',
                        'categoria' => 'paquete',
                        'orden_prioridad' => 1
                    ]
                ];
            }
            break;
            
        default:
            $response = [
                'success' => false,
                'error' => 'Método no soportado',
                'supported_methods' => ['GET', 'POST'],
                'info' => 'API de Promociones implementada según criterios del issue @RudyC-90'
            ];
            break;
    }
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => 'Error interno del servidor',
        'message' => $e->getMessage(),
        'timestamp' => date('c')
    ];
    http_response_code(500);
}

// Cerrar conexión si existe
if (isset($conn)) {
    $conn->close();
}

// Enviar respuesta
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
