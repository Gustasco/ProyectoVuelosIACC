# 🌍 Sistema de Gestión de Agencia de Viajes

## 📋 Descripción del Proyecto

Sistema web completo para la gestión de una agencia de viajes desarrollado en PHP, HTML, CSS y MySQL. Permite gestionar vuelos, hoteles y reservas de manera integral con una interfaz moderna y responsiva.

## ✨ Características Principales

- 🔍 **Búsqueda Avanzada de Vuelos**: Sistema completo con filtros múltiples (precio, aerolínea, horarios)
- ✈️ **Gestión de Vuelos**: Agregar, modificar y consultar vuelos disponibles
- 🏨 **Gestión de Hoteles**: Administración completa de hoteles y habitaciones
- 📋 **Sistema de Reservas**: Gestión integral de reservas de clientes con estadísticas
- 📱 **Diseño Responsivo**: Interfaz adaptada para dispositivos móviles
- 🎨 **Interfaz Moderna**: Diseño atractivo con gradientes y animaciones CSS
- 🔄 **Workflow GitHub**: Templates de colaboración y buenas prácticas implementadas
- 🛡️ **Seguridad**: Consultas SQL preparadas y validación de datos

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
├── .github/                    # Templates de GitHub para colaboración
│   ├── ISSUE_TEMPLATE/        # Templates para issues
│   │   ├── bug_report.md      # Template para reportes de bugs
│   │   ├── feature_request.md # Template para solicitudes de funcionalidades
│   │   └── documentation.md   # Template para mejoras de documentación
│   └── PULL_REQUEST_TEMPLATE/ # Templates para pull requests
│       └── pull_request_template.md # Template para PRs con checklist
├── database/
│   └── agencia_viajes.sql     # Script de creación de la base de datos
├── install_auto.bat           # Script de instalación automática (Windows)
├── conexion.php               # Configuración de conexión a la base de datos
├── index.html                 # Página principal con búsqueda integrada
├── busqueda_avanzada.html     # Sistema de búsqueda avanzada de vuelos
├── api_busqueda_vuelos.php    # API backend para búsqueda de vuelos
├── form_buscar.html          # Formulario de búsqueda de vuelos
├── form_vuelo.html           # Formulario para agregar vuelos
├── form_hotel.html           # Formulario para agregar hoteles
├── mostrar_vuelo.php         # Mostrar resultados de búsqueda de vuelos
├── mostrar_reservas.php      # Mostrar todas las reservas con estadísticas
├── consulta_reservas.php     # Consultar reservas específicas
├── insertar_vuelo.php        # Procesar inserción de vuelos
├── insertar_hotel.php        # Procesar inserción de hoteles
├── insertar_reservas.php     # Procesar inserción de reservas
├── ISSUE_HOTEL_INTEGRATION.md # Issue para discusión de integración de hoteles
├── ASSIGNMENT_RESUMEN.md      # Resumen del assignment de colaboración GitHub
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

### Paso 5: Acceder al Sistema

1. Abrir navegador web
2. Ir a `http://localhost/agencia/`
3. ¡El sistema estará listo para usar!

## 🎯 Uso del Sistema

### Página Principal
- **URL**: `http://localhost/agencia/index.html`
- **Funciones**: Búsqueda rápida de vuelos, navegación a todas las secciones

### Búsqueda Avanzada de Vuelos ⭐ NUEVO
- **URL**: `http://localhost/agencia/busqueda_avanzada.html`
- **Funciones**: 
  - Filtros múltiples (precio, aerolínea, horarios, opciones)
  - Estadísticas de resultados en tiempo real
  - Interfaz moderna con validación
  - Integración con base de datos MySQL

### Búsqueda de Vuelos (Básica)
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
- **Funciones**: Dashboard con estadísticas y reportes visuales

## 🐛 Solución de Problemas

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

### 📋 **Templates de GitHub Configurados**

El proyecto incluye templates profesionales para mejorar la colaboración:

#### **Issue Templates** (`.github/ISSUE_TEMPLATE/`):
- 🐛 **Bug Report** (`bug_report.md`) - Reportes estructurados con información técnica
- ✨ **Feature Request** (`feature_request.md`) - Solicitudes con criterios de aceptación
- 📚 **Documentation** (`documentation.md`) - Mejoras de documentación

#### **Pull Request Template** (`.github/PULL_REQUEST_TEMPLATE/`):
- 🔄 **PR Template** - Checklist completo de calidad, seguridad y testing
- ✅ Validación de código, base de datos, frontend y seguridad
- 👀 Guía para reviewers con criterios específicos

### 🌿 **Workflow de Desarrollo**

#### **Estructura de Ramas:**
- `main` - Rama principal (producción)
- `rama-gustavo` - Rama de desarrollo principal
- `feature/*` - Ramas para nuevas funcionalidades
- `fix/*` - Ramas para corrección de bugs
- `docs/*` - Ramas para mejoras de documentación

#### **Ejemplo de Workflow:**
1. Crear rama desde `rama-gustavo`: `feature/busqueda-avanzada`
2. Desarrollar funcionalidad con commits descriptivos
3. Crear Pull Request usando template
4. Review colaborativo con comentarios
5. Merge tras aprobación

### 🚀 **Funcionalidades Recientes**

#### **v2.1 - Búsqueda Avanzada** ⭐
- Sistema completo de filtros múltiples
- API REST con consultas SQL optimizadas
- Estadísticas en tiempo real
- Interfaz responsive moderna

#### **Próximas Funcionalidades** (ver `ISSUE_HOTEL_INTEGRATION.md`):
- Sistema integrado de paquetes vuelo + hotel
- Búsqueda avanzada de hoteles
- Dashboard unificado de reservas
- Sistema de calificaciones

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
- **v2.1** - ⭐ **ACTUAL** - Búsqueda avanzada de vuelos y templates de GitHub colaborativo

### Changelog v2.1:
- ✅ Sistema de búsqueda avanzada de vuelos con filtros múltiples
- ✅ API backend `api_busqueda_vuelos.php` con consultas SQL seguras
- ✅ Templates GitHub para issues y pull requests
- ✅ Workflow colaborativo establecido con buenas prácticas
- ✅ Issue documentado para integración de sistema de hoteles
- ✅ Interfaz moderna responsive con CSS Grid
- ✅ Estadísticas de búsqueda en tiempo real

### En Desarrollo (v2.2):
- 🔄 Sistema integrado de reservas de hoteles
- 🔄 Paquetes combinados vuelo + hotel
- 🔄 Dashboard unificado de administración

---

**¡Gracias por usar nuestro Sistema de Gestión de Agencia de Viajes!** 🌍✈️🏨
