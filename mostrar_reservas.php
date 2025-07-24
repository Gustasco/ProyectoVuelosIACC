<?php
include("conexion.php");

// Consulta mejorada con JOINs para mostrar información más útil
$sql = "
  SELECT 
    r.id,
    r.codigo_reserva,
    r.cliente_nombre,
    r.cliente_email,
    r.tipo_reserva,
    r.fecha_reserva,
    r.fecha_viaje,
    r.numero_pasajeros,
    r.precio_final,
    r.estado,
    v.origen,
    v.destino,
    v.numero_vuelo,
    h.nombre AS hotel_nombre,
    h.ciudad AS hotel_ciudad
  FROM reserva r
  LEFT JOIN vuelo v ON r.vuelo_id = v.id
  LEFT JOIN hotel h ON r.hotel_id = h.id
  ORDER BY r.fecha_reserva DESC
";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservas Registradas - Agencia de Viajes</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="form_buscar.html">Buscar Vuelos</a></li>
        <li><a href="form_vuelo.html">Agregar Vuelo</a></li>
        <li><a href="form_hotel.html">Agregar Hotel</a></li>
        <li><a href="consulta_reservas.php">Ver Reservas</a></li>
      </ul>
    </nav>
    
    <h2>📋 Todas las Reservas Registradas</h2>
    
    <?php if ($resultado && $resultado->num_rows > 0): ?>
      <p class="results-count">📊 Total de reservas: <strong><?= $resultado->num_rows ?></strong></p>
      
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>📋 Código</th>
              <th>👤 Cliente</th>
              <th>📧 Email</th>
              <th>🎯 Tipo</th>
              <th>📅 Fecha Reserva</th>
              <th>✈️🏨 Detalles</th>
              <th>👥 Pasajeros</th>
              <th>💰 Precio</th>
              <th>📊 Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
              <tr>
                <td class="codigo-reserva"><?= htmlspecialchars($fila['codigo_reserva']) ?></td>
                <td><?= htmlspecialchars($fila['cliente_nombre']) ?></td>
                <td><?= htmlspecialchars($fila['cliente_email']) ?></td>
                <td>
                  <span class="tipo-reserva tipo-<?= $fila['tipo_reserva'] ?>">
                    <?php 
                    switch($fila['tipo_reserva']) {
                      case 'vuelo': echo '✈️ Vuelo'; break;
                      case 'hotel': echo '🏨 Hotel'; break;
                      case 'paquete': echo '📦 Paquete'; break;
                      default: echo $fila['tipo_reserva'];
                    }
                    ?>
                  </span>
                </td>
                <td><?= date('d/m/Y', strtotime($fila['fecha_reserva'])) ?></td>
                <td class="detalles-servicio">
                  <?php if ($fila['tipo_reserva'] == 'vuelo' || $fila['tipo_reserva'] == 'paquete'): ?>
                    <div class="vuelo-info">
                      <strong><?= htmlspecialchars($fila['numero_vuelo']) ?></strong><br>
                      <small><?= htmlspecialchars($fila['origen']) ?> → <?= htmlspecialchars($fila['destino']) ?></small>
                    </div>
                  <?php endif; ?>
                  
                  <?php if ($fila['tipo_reserva'] == 'hotel' || $fila['tipo_reserva'] == 'paquete'): ?>
                    <div class="hotel-info">
                      <strong><?= htmlspecialchars($fila['hotel_nombre']) ?></strong><br>
                      <small><?= htmlspecialchars($fila['hotel_ciudad']) ?></small>
                    </div>
                  <?php endif; ?>
                  
                  <?php if (!$fila['numero_vuelo'] && !$fila['hotel_nombre']): ?>
                    <small class="no-detalles">Sin detalles específicos</small>
                  <?php endif; ?>
                </td>
                <td class="text-center"><?= htmlspecialchars($fila['numero_pasajeros']) ?></td>
                <td class="precio">$<?= number_format($fila['precio_final'], 2) ?></td>
                <td>
                  <span class="estado estado-<?= $fila['estado'] ?>">
                    <?php 
                    switch($fila['estado']) {
                      case 'pendiente': echo '⏳ Pendiente'; break;
                      case 'confirmada': echo '✅ Confirmada'; break;
                      case 'pagada': echo '💳 Pagada'; break;
                      case 'cancelada': echo '❌ Cancelada'; break;
                      case 'completada': echo '🎉 Completada'; break;
                      default: echo $fila['estado'];
                    }
                    ?>
                  </span>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      
      <!-- Estadísticas resumidas -->
      <div class="stats-summary">
        <h3>📈 Resumen de Reservas</h3>
        <?php 
        // Reiniciar resultado para estadísticas
        $resultado = $conn->query($sql);
        $stats = [
          'vuelo' => 0,
          'hotel' => 0,
          'paquete' => 0,
          'pendiente' => 0,
          'confirmada' => 0,
          'pagada' => 0,
          'total_ingresos' => 0
        ];
        
        while ($fila = $resultado->fetch_assoc()) {
          $stats[$fila['tipo_reserva']]++;
          $stats[$fila['estado']]++;
          if ($fila['estado'] != 'cancelada') {
            $stats['total_ingresos'] += $fila['precio_final'];
          }
        }
        ?>
        
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">✈️</div>
            <div class="stat-info">
              <div class="stat-number"><?= $stats['vuelo'] ?></div>
              <div class="stat-label">Vuelos</div>
            </div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon">🏨</div>
            <div class="stat-info">
              <div class="stat-number"><?= $stats['hotel'] ?></div>
              <div class="stat-label">Hoteles</div>
            </div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
              <div class="stat-number"><?= $stats['paquete'] ?></div>
              <div class="stat-label">Paquetes</div>
            </div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
              <div class="stat-number">$<?= number_format($stats['total_ingresos'], 0) ?></div>
              <div class="stat-label">Ingresos</div>
            </div>
          </div>
        </div>
      </div>
      
    <?php else: ?>
      <div class="message no-results">
        <h3>📋 No hay reservas registradas</h3>
        <p>Aún no se han registrado reservas en el sistema.</p>
        <p>💡 <strong>Sugerencias:</strong></p>
        <ul>
          <li>Verifica que la base de datos esté correctamente configurada</li>
          <li>Asegúrate de que los datos de prueba se hayan cargado</li>
          <li>Intenta crear una nueva reserva desde el sistema</li>
        </ul>
        <div class="action-buttons">
          <a href="form_vuelo.html" class="btn">✈️ Agregar Vuelo</a>
          <a href="form_hotel.html" class="btn">🏨 Agregar Hotel</a>
        </div>
      </div>
    <?php endif; ?>
    
    <div class="action-buttons">
      <a href="consulta_reservas.php" class="btn">📊 Consultas Especiales</a>
      <a href="index.html" class="btn btn-secondary">🏠 Volver al Inicio</a>
    </div>
  </div>
</body>
</html>
