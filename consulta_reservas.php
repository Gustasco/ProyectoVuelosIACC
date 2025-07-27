<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultas de Reservas - Agencia de Viajes</title>
  
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
    
    .results-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(30, 60, 114, 0.1);
      padding: 30px;
      margin-top: -30px;
      position: relative;
      z-index: 10;
    }
    
    .hotel-card {
      background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
      border: 1px solid rgba(52, 152, 219, 0.2);
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }
    
    .hotel-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(30, 60, 114, 0.15);
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
              <li><a class="dropdown-item fw-semibold active" href="consulta_reservas.php" 
                     style="border-radius: 8px; padding: 10px 16px; color: #1e3c72; transition: all 0.3s ease; background: rgba(52, 152, 219, 0.1);"
                     onmouseover="this.style.background='linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='rgba(52, 152, 219, 0.1)'; this.style.transform='translateX(0)'">
                <i class="bi bi-eye-fill text-info"></i> Ver Reservas
              </a></li>
              <li><a class="dropdown-item fw-semibold" href="mostrar_reservas.php" 
                     style="border-radius: 8px; padding: 10px 16px; color: #1e3c72; transition: all 0.3s ease;"
                     onmouseover="this.style.background='linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='transparent'; this.style.transform='translateX(0)'">
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
        <i class="bi bi-bar-chart-fill"></i> Consultas de Reservas
      </h1>
      <p class="lead">Análisis estadístico de hoteles con alta demanda</p>
    </div>
  </section>

  <div class="container">
    <div class="results-container">
      <h2 class="text-center mb-4" style="color: #1e3c72;">
        <i class="bi bi-building-fill-check"></i> Hoteles con más de 2 reservas
      </h2>
    <?php
    $sql = "
      SELECT h.nombre, COUNT(*) AS total_reservas
      FROM reserva r
      JOIN hotel h ON r.hotel_id = h.id
      WHERE r.hotel_id IS NOT NULL
      GROUP BY r.hotel_id, h.nombre
      HAVING COUNT(*) > 2
      ORDER BY total_reservas DESC
    ";

    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        echo "<div class='row'>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div class='col-lg-6 mb-4'>";
            echo "<div class='hotel-card'>";
            echo "<h4 style='color: #1e3c72;'><i class='bi bi-building-fill'></i> " . htmlspecialchars($fila['nombre']) . "</h4>";
            echo "<div class='d-flex align-items-center mt-3'>";
            echo "<span class='badge bg-primary fs-6 me-2'><i class='bi bi-calendar-check'></i> " . $fila['total_reservas'] . " reservas</span>";
            echo "<small class='text-muted'>Hotel con alta demanda</small>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='alert alert-info text-center'>";
        echo "<h4><i class='bi bi-info-circle'></i> Sin resultados</h4>";
        echo "<p class='mb-3'>No hay hoteles con más de 2 reservas en este momento.</p>";
        echo "<div class='alert alert-light'>";
        echo "<p><strong><i class='bi bi-lightbulb'></i> Nota:</strong> Esto puede ser porque:</p>";
        echo "<ul class='text-start'>";
        echo "<li>Los hoteles registrados tienen pocas reservas</li>";
        echo "<li>Las reservas están asociadas principalmente a vuelos</li>";
        echo "<li>Se necesitan más datos de prueba</li>";
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }

    // Mostrar estadísticas adicionales
    echo "<div class='stats-section'>";
    echo "<h3>📈 Estadísticas Generales</h3>";
    
    // Total de hoteles
    $sql_hoteles = "SELECT COUNT(*) as total FROM hotel WHERE estado = 'activo'";
    $result_hoteles = $conn->query($sql_hoteles);
    $total_hoteles = $result_hoteles->fetch_assoc()['total'];
    
    // Total de reservas de hotel
    $sql_reservas = "SELECT COUNT(*) as total FROM reserva WHERE hotel_id IS NOT NULL";
    $result_reservas = $conn->query($sql_reservas);
    $total_reservas = $result_reservas->fetch_assoc()['total'];
    
    echo "<div class='col-md-6'>";
    echo "<div class='stat-card text-center p-4'>";
    echo "<div class='stat-number' style='color: #3498db; font-size: 3rem; font-weight: bold;'>$total_hoteles</div>";
    echo "<div class='stat-label h5' style='color: #1e3c72;'><i class='bi bi-building'></i> Hoteles Registrados</div>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='col-md-6'>";
    echo "<div class='stat-card text-center p-4'>";
    echo "<div class='stat-number' style='color: #3498db; font-size: 3rem; font-weight: bold;'>$total_reservas</div>";
    echo "<div class='stat-label h5' style='color: #1e3c72;'><i class='bi bi-calendar-check'></i> Reservas de Hotel</div>";
    echo "</div>";
    echo "</div>";
    
    echo "</div>";
    ?>
      
      <div class="text-center mt-4">
        <a href="mostrar_reservas.php" class="btn btn-primary btn-lg me-3">
          <i class="bi bi-table"></i> Ver Todas las Reservas
        </a>
        <a href="index.html" class="btn btn-secondary btn-lg">
          <i class="bi bi-house-fill"></i> Volver al Inicio
        </a>
      </div>
    </div>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
