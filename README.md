# 🌍 Sistema de Gestión de Agencia de Viajes

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

### Paso 3: Instalación Automática (Recomendado)

#### Opción A: Instalador Inteligente (Windows)
```bash
# Ejecutar como administrador - Detecta XAMPP automáticamente
install_auto.bat
```

#### Opción B: Instalador Simple (Windows)
```bash
# Si ya modificaste la ruta de XAMPP
install.bat
```

### Paso 4: Instalación Manual (Si los scripts fallan)

1. **Configurar XAMPP:**
   - Iniciar Apache y MySQL en XAMPP Control Panel
   - Verificar que ambos servicios estén en "Running" (verde)

2. **Crear Base de Datos:**
   - Abrir `http://localhost/phpmyadmin`
   - Crear nueva base de datos: `agencia_viajes`
   - Importar archivo: `database/agencia_viajes.sql`

3. **Verificar Conexión:**
   - Comprobar que `conexion.php` tenga las credenciales correctas
   - Verificar que apunte al puerto correcto de MySQL

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
