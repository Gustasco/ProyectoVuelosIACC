# 🌍 Sistema de Gestión de Agencia de Viajes

## ⚡ Inicio Rápido

**📌 Configuración esencial ANTES de usar el sistema:**

1. **Instalar XAMPP** y iniciar Apache + MySQL
2. **Configurar contraseña de MySQL** en `conexion.php`:
   ```php
   $contrasena = 'root';  // ⚠️ Cambiar de '' a 'root' si es necesario
   ```
3. **Ejecutar**: `install_auto.bat` (detecta XAMPP automáticamente)
4. **Abrir**: `http://localhost/agencia/`

> 💡 **Problema común**: Si ves errores JSON, revisar la contraseña de MySQL en `conexion.php`

---

## 📋 Descripción del Proyecto

Sistema web completo para la gestión de una agencia de viajes desarrollado en PHP, HTML, CSS y MySQL. Permite gestionar vuelos, hoteles y reservas de manera integral con una interfaz moderna y responsiva.

## ✨ Características Principales

- 🔍 **Búsqueda de Vuelos**: Sistema avanzado de búsqueda por origen, destino y fecha
- ✈️ **Gestión de Vuelos**: Agregar, modificar y consultar vuelos disponibles
- 🏨 **Gestión de Hoteles**: Administración completa de hoteles y habitaciones
- 📋 **Sistema de Reservas**: Gestión integral de reservas de clientes
- 📱 **Diseño Responsivo**: Interfaz adaptada para dispositivos móviles
- 🎨 **Interfaz Moderna**: Diseño atractivo con gradientes y animaciones

## 🛠️ Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Servidor Local**: XAMPP
- **Control de Versiones**: Git

## 📁 Estructura del Proyecto

```
agencia/
├── README.md                   # Documentación del proyecto
├── database/
│   └── agencia_viajes.sql     # Script de creación de la base de datos
├── install_auto.bat           # Script de instalación automática (Windows)
├── conexion.php               # Configuración de conexión a la base de datos
├── index.html                 # Página principal con búsqueda integrada
├── form_buscar.html          # Formulario de búsqueda de vuelos
├── form_vuelo.html           # Formulario para agregar vuelos
├── form_hotel.html           # Formulario para agregar hoteles
├── mostrar_vuelo.php         # Mostrar resultados de búsqueda de vuelos
├── mostrar_reservas.php      # Mostrar todas las reservas
├── consulta_reservas.php     # Consultar reservas específicas
├── insertar_vuelo.php        # Procesar inserción de vuelos
├── insertar_hotel.php        # Procesar inserción de hoteles
├── insertar_reservas.php     # Procesar inserción de reservas
└── styles.css                # Estilos CSS del proyecto
```

## 🚀 Instalación y Configuración

### Prerrequisitos

- XAMPP instalado (incluye Apache, MySQL y PHP)
- Navegador web moderno
- Git (opcional, para clonar el repositorio)

### Paso 1: Descargar XAMPP

1. Descargar XAMPP desde [https://www.apachefriends.org](https://www.apachefriends.org)
2. Instalar XAMPP en cualquier ubicación (C:\, D:\, F:\, etc.)
3. Ejecutar XAMPP Control Panel

### Paso 2: Clonar o Descargar el Proyecto

#### Opción A: Clonar con Git
```bash
git clone https://github.com/Gustasco/ProyectoVuelosIACC.git
cd ProyectoVuelosIACC
```

#### Opción B: Descargar ZIP
1. Descargar el proyecto desde GitHub
2. Extraer en la carpeta `htdocs` de XAMPP

### Paso 3: Instalación Automática

#### Instalador Inteligente (Windows) - Recomendado
```bash
# Ejecutar como administrador - Detecta XAMPP automáticamente
install_auto.bat
```

El instalador automático:
- 🔍 Detecta XAMPP en múltiples ubicaciones
- 🛠️ Resuelve conflictos de puerto automáticamente  
- ✅ Verifica servicios y conexión
- 🗄️ Crea la base de datos completa
- 🚀 Abre el sistema automáticamente

### Paso 4: Instalación Manual (Solo si el script falla)

1. **Configurar XAMPP:**
   - Iniciar Apache y MySQL en XAMPP Control Panel
   - Verificar que ambos servicios estén en "Running" (verde)

2. **Crear Base de Datos:**
   - Abrir `http://localhost/phpmyadmin`
   - Crear nueva base de datos: `agencia_viajes`
   - Importar archivo: `database/agencia_viajes.sql`

3. **Verificar Conexión:**
   - Comprobar que `conexion.php` tenga las credenciales correctas
   - **⚠️ IMPORTANTE**: Si MySQL requiere contraseña, actualizar en `conexion.php`:
     ```php
     $contrasena = 'root';  // Cambiar de '' a 'root' si es necesario
     ```

4. **Configuración de MySQL:**
   - **Usuario por defecto**: `root`
   - **Contraseña común**: `root` o vacía `''`
   - **Puerto**: `3306`
   - **Host**: `localhost`
   
   Si tienes problemas de conexión:
   - Abrir phpMyAdmin: `http://localhost/phpmyadmin`
   - Verificar que puedes acceder con usuario `root`
   - Si requiere contraseña, usar `root` como contraseña
   - Actualizar archivo `conexion.php` con las credenciales correctas

### Paso 5: Acceder al Sistema

1. Abrir navegador web
2. Ir a `http://localhost/agencia/`
3. ¡El sistema estará listo para usar!

## 🎯 Uso del Sistema

### Página Principal
- **URL**: `http://localhost/agencia/index.html`
- **Funciones**: Búsqueda rápida de vuelos, navegación a todas las secciones

### Búsqueda de Vuelos
- **URL**: `http://localhost/agencia/form_buscar.html`
- **Función**: Buscar vuelos por origen, destino y fecha

### Gestión de Vuelos
- **Agregar**: `http://localhost/agencia/form_vuelo.html`
- **Función**: Registrar nuevos vuelos en el sistema

### Gestión de Hoteles
- **Agregar**: `http://localhost/agencia/form_hotel.html`
- **Función**: Registrar hoteles y habitaciones

### Gestión de Reservas
- **Consultar**: `http://localhost/agencia/consulta_reservas.php`
- **Ver todas**: `http://localhost/agencia/mostrar_reservas.php`

## 🐛 Solución de Problemas

### ❌ Error de Conexión a MySQL
**Error**: `Access denied for user 'root'@'localhost' (using password: NO)`

**Solución**:
1. **Verificar contraseña de MySQL**:
   - Abrir `conexion.php`
   - Cambiar la línea: `$contrasena = '';` por `$contrasena = 'root';`
   
2. **Probar conexión**:
   - Ir a `http://localhost/phpmyadmin`
   - Intentar acceder con usuario: `root` y contraseña: `root`
   - Si funciona, la configuración es correcta

3. **Configuraciones comunes de XAMPP**:
   ```php
   // Opción 1: Sin contraseña (XAMPP por defecto)
   $contrasena = '';
   
   // Opción 2: Con contraseña 'root' (XAMPP configurado)
   $contrasena = 'root';
   ```

### ❌ Error JSON en Promociones
**Error**: `SyntaxError: Unexpected token '<', "<br />"`

**Causa**: Errores PHP se muestran como HTML en lugar de JSON

**Solución**:
1. Verificar que MySQL esté conectando correctamente
2. Revisar que la base de datos `agencia_viajes` exista
3. Ejecutar `php instalar_promociones.php` para instalar datos de prueba

### Error de Conexión a la Base de Datos
- Verificar que MySQL esté corriendo en XAMPP
- Comprobar credenciales en `conexion.php`
- Asegurar que la base de datos `agencia_viajes` exista

### Página no se Carga
- Verificar que Apache esté corriendo
- Comprobar que el proyecto esté en la carpeta `htdocs`
- Verificar la URL: `http://localhost/nombre-carpeta-proyecto`

### Errores de PHP
- Verificar que PHP esté habilitado en XAMPP
- Comprobar que no hay errores de sintaxis en los archivos PHP
- Revisar logs de errores en XAMPP

## 🔧 Desarrollo

### Estructura de la Base de Datos

El sistema utiliza las siguientes tablas principales:
- `vuelo`: Información de vuelos disponibles
- `hotel`: Datos de hoteles registrados
- `reserva`: Registros de reservas de clientes

### Arquitectura del Proyecto

- **MVC Pattern**: Separación entre lógica de negocio y presentación
- **Responsive Design**: CSS Grid y Flexbox para adaptabilidad
- **Security**: Uso de prepared statements para prevenir SQL injection

## 👥 Colaboración y Desarrollo

### 🤝 **Guía para Colaboradores**

Este proyecto utiliza **GitHub Flow** para el trabajo colaborativo. Sigue estas prácticas:

#### **🌳 Flujo de Trabajo con Ramas:**
1. **main** - Código estable y funcional
2. **feature/nombre-funcionalidad** - Nuevas características
3. **fix/nombre-bug** - Corrección de errores
4. **docs/nombre-doc** - Actualizaciones de documentación

#### **📋 Proceso de Contribución:**
1. Hacer fork del repositorio
2. Crear rama para tu funcionalidad: `git checkout -b feature/busqueda-avanzada`
3. Desarrollar y hacer commits descriptivos
4. Crear Pull Request con descripción detallada
5. Revisar y aprobar cambios
6. Merge a la rama principal

#### **💬 Comunicación:**
- Usar **Issues** para reportar bugs y proponer funcionalidades
- Comentar **Pull Requests** de forma constructiva
- Seguir las plantillas de Issue y PR
- Etiquetar apropiadamente: `bug`, `enhancement`, `documentation`

### 🔧 **Configuración para Desarrollo**

#### **Variables de Entorno:**
```php
// Para desarrollo local
$host = 'localhost:3306';
$usuario = 'root';
$contrasena = '';
$bd = 'agencia_viajes_dev'; // Base de datos de desarrollo
```

#### **Estándares de Código:**
- **PHP**: PSR-12 coding standard
- **JavaScript**: ES6+ features
- **CSS**: BEM methodology para clases
- **Commits**: Conventional Commits format

## 👥 Contribuidores

- **Gustasco** - Desarrollador Principal
- **RudyC-90** - Colaborador

## 📝 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## 📞 Soporte

Para soporte técnico o consultas:
- **GitHub Issues**: [Crear un issue](https://github.com/Gustasco/ProyectoVuelosIACC/issues)
- **Email**: gustavo.espinoza.aliste@gmail.com

## 🚀 Versiones

- **v1.0** - Versión inicial con funcionalidades básicas
- **v2.0** - Mejoras en la interfaz y sistema de búsqueda

---

**¡Gracias por usar nuestro Sistema de Gestión de Agencia de Viajes!** 🌍✈️🏨
