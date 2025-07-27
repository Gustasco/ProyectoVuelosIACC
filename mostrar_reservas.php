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
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles.css" />
  
  <style>
    .page-header {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3498db 100%);
      color: white;
      padding: 60px 0;
    }
    
    .table-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(30, 60, 114, 0.1);
      overflow: hidden;
      margin-top: -30px;
      position: relative;
      z-index: 10;
    }
  </style>
</head>
<body>
  <!-- Navigation - Tema Azul y Blanco Unificado -->
  <nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3498db 100%); box-shadow: 0 4px 20px rgba(30, 60, 114, 0.3);">
    <div class="container">
      <a class="navbar-brand text-white fw-bold" href="index.html" style="font-size: 1.4rem;">
        <i class="bi bi-airplane"></i> Agencia de Viajes
      </a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              style="border: 1px solid rgba(255,255,255,0.3);">
        <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 30 30\'%3e%3cpath stroke=\'rgba%28255, 255, 255, 0.8%29\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' stroke-width=\'2\' d=\'M4 7h22M4 15h22M4 23h22\'/%3e%3c/svg%3e');"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link text-white fw-semibold" href="index.html" 
               style="transition: all 0.3s ease; border-radius: 8px; padding: 8px 16px;"
               onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='transparent'; this.style.transform='translateY(0)'">
              <i class="bi bi-house-fill"></i> Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white fw-semibold" href="form_buscar.html" 
               style="transition: all 0.3s ease; border-radius: 8px; padding: 8px 16px;"
               onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='transparent'; this.style.transform='translateY(0)'">
              <i class="bi bi-search"></i> Buscar Vuelos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white fw-semibold" href="promociones_dinamicas.html" 
               style="transition: all 0.3s ease; border-radius: 8px; padding: 8px 16px;"
               onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='transparent'; this.style.transform='translateY(0)'">
              <i class="bi bi-tags-fill"></i> Promociones
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown"
               style="transition: all 0.3s ease; border-radius: 8px; padding: 8px 16px;"
               onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='transparent'; this.style.transform='translateY(0)'">
              <i class="bi bi-gear-fill"></i> Gestión
            </a>
            <ul class="dropdown-menu border-0 shadow-lg" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-radius: 12px; padding: 8px;">
              <li><a class="dropdown-item fw-semibold" href="form_vuelo.html" 
                     style="border-radius: 8px; padding: 10px 16px; color: #1e3c72; transition: all 0.3s ease;"
                     onmouseover="this.style.background='linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='transparent'; this.style.transform='translateX(0)'">
                <i class="bi bi-airplane-fill text-primary"></i> Agregar Vuelo
              </a></li>
              <li><a class="dropdown-item fw-semibold" href="form_hotel.html" 
                     style="border-radius: 8px; padding: 10px 16px; color: #1e3c72; transition: all 0.3s ease;"
                     onmouseover="this.style.background='linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='transparent'; this.style.transform='translateX(0)'">
                <i class="bi bi-building text-success"></i> Agregar Hotel
              </a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fw-semibold active" href="#" role="button" data-bs-toggle="dropdown"
               style="transition: all 0.3s ease; border-radius: 8px; padding: 8px 16px; background: rgba(255,255,255,0.2);"
               onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
              <i class="bi bi-calendar-check-fill"></i> Reservas
            </a>
            <ul class="dropdown-menu border-0 shadow-lg" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-radius: 12px; padding: 8px;">
              <li><a class="dropdown-item fw-semibold" href="consulta_reservas.php" 
                     style="border-radius: 8px; padding: 10px 16px; color: #1e3c72; transition: all 0.3s ease;"
                     onmouseover="this.style.background='linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='transparent'; this.style.transform='translateX(0)'">
                <i class="bi bi-eye-fill text-info"></i> Ver Reservas
              </a></li>
              <li><a class="dropdown-item fw-semibold active" href="mostrar_reservas.php" 
                     style="border-radius: 8px; padding: 10px 16px; color: #1e3c72; transition: all 0.3s ease; background: rgba(52, 152, 219, 0.1);"
                     onmouseover="this.style.background='linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='rgba(52, 152, 219, 0.1)'; this.style.transform='translateX(0)'">
                <i class="bi bi-table text-warning"></i> Todas las Reservas
              </a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <section class="page-header">
    <div class="container text-center">
      <h1 class="display-5 mb-3">
        <i class="bi bi-table"></i> Todas las Reservas
      </h1>
      <p class="lead">Gestión completa de reservas registradas en el sistema</p>
    </div>
  </section>

  <div class="container">
    
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
          <a href="form_vuelo.html" class="btn btn-primary">
            <i class="bi bi-airplane-fill"></i> Agregar Vuelo
          </a>
          <a href="form_hotel.html" class="btn btn-success">
            <i class="bi bi-building"></i> Agregar Hotel
          </a>
        </div>
      </div>
    <?php endif; ?>
    
    <div class="action-buttons mt-4">
      <a href="consulta_reservas.php" class="btn btn-info">
        <i class="bi bi-bar-chart-fill"></i> Consultas Especiales
      </a>
      <a href="index.html" class="btn btn-secondary">
        <i class="bi bi-house-fill"></i> Volver al Inicio
      </a>
    </div>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
