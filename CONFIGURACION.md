# 🔧 Guía de Configuración Rápida

## 📋 Lista de Verificación Pre-Instalación

### ✅ Requisitos del Sistema
- [ ] XAMPP instalado en `C:\xampp\`
- [ ] Apache corriendo en puerto 80
- [ ] MySQL corriendo en puerto 3306
- [ ] PHP 7.4 o superior
- [ ] Navegador web moderno

### ✅ Verificar XAMPP
1. Abrir XAMPP Control Panel
2. Iniciar Apache (botón "Start")
3. Iniciar MySQL (botón "Start")
4. Verificar que ambos tengan estado "Running"

## 🚀 Instalación Rápida

### Opción 1: Script Automático (Windows)
```bash
# Ejecutar como administrador
install.bat
```

### Opción 2: Instalación Manual

#### Paso 1: Crear Base de Datos
```sql
-- En phpMyAdmin (http://localhost/phpmyadmin)
1. Crear nueva base de datos: agencia_viajes
2. Seleccionar la base de datos
3. Ir a pestaña "SQL"
4. Copiar y pegar contenido de: database/agencia_viajes.sql
5. Hacer clic en "Continuar"
```

#### Paso 2: Verificar Conexión
```php
// Archivo: conexion.php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';  // Vacío por defecto en XAMPP
$bd = 'agencia_viajes';
```

#### Paso 3: Acceder al Sistema
```
URL: http://localhost/agencia/
```

## 🔍 Solución de Problemas Comunes

### Error: "No se puede conectar a la base de datos"
```
Solución:
1. Verificar que MySQL esté corriendo en XAMPP
2. Comprobar credenciales en conexion.php
3. Verificar que la base de datos 'agencia_viajes' exista
```

### Error: "Página no encontrada"
```
Solución:
1. Verificar que Apache esté corriendo
2. Confirmar que el proyecto esté en C:\xampp\htdocs\agencia\
3. Usar la URL correcta: http://localhost/agencia/
```

### Error: "Access denied for user 'root'"
```
Solución:
1. En phpMyAdmin, ir a "User accounts"
2. Editar usuario 'root'
3. Verificar privilegios
4. Asegurarse de que no requiera contraseña
```

## 📊 Datos de Prueba Incluidos

El script SQL incluye datos de ejemplo:
- 8 vuelos de prueba
- 8 hoteles de ejemplo
- 5 clientes de muestra
- 5 reservas de ejemplo

## 🔧 Configuración Avanzada

### Cambiar Puerto de Apache
```
1. XAMPP Control Panel → Apache → Config → httpd.conf
2. Buscar: Listen 80
3. Cambiar a: Listen 8080
4. Reiniciar Apache
5. Nueva URL: http://localhost:8080/agencia/
```

### Habilitar Contraseña para MySQL
```sql
-- En phpMyAdmin
SET PASSWORD FOR 'root'@'localhost' = PASSWORD('nueva_contraseña');
FLUSH PRIVILEGES;

-- Actualizar conexion.php
$contrasena = 'nueva_contraseña';
```

### Configurar Email (Opcional)
```php
// Para notificaciones por email
$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_user = 'tu-email@gmail.com';
$smtp_pass = 'tu-contraseña-app';
```

## 📱 URLs del Sistema

| Página | URL | Descripción |
|--------|-----|-------------|
| Principal | `http://localhost/agencia/` | Página de inicio con búsqueda |
| Buscar Vuelos | `http://localhost/agencia/form_buscar.html` | Formulario de búsqueda |
| Agregar Vuelo | `http://localhost/agencia/form_vuelo.html` | Registro de vuelos |
| Agregar Hotel | `http://localhost/agencia/form_hotel.html` | Registro de hoteles |
| Ver Reservas | `http://localhost/agencia/consulta_reservas.php` | Consulta de reservas |
| Todas las Reservas | `http://localhost/agencia/mostrar_reservas.php` | Lista completa |
| phpMyAdmin | `http://localhost/phpmyadmin/` | Administración de BD |

## 🆘 Soporte

### Logs de Error
```
Apache: C:\xampp\apache\logs\error.log
MySQL: C:\xampp\mysql\data\mysql_error.log
PHP: C:\xampp\php\logs\php_error_log
```

### Contacto
- GitHub: https://github.com/Gustasco/ProyectoVuelosIACC
- Email: gustavo.espinoza.aliste@gmail.com
