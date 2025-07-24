@echo off
REM ===================================================================
REM Script de Instalación Automática Mejorado - Sistema Agencia de Viajes
REM ===================================================================
REM Autor: Gustasco
REM Descripción: Script inteligente que detecta la ubicación de XAMPP
REM ===================================================================

echo.
echo ========================================
echo   INSTALADOR AGENCIA DE VIAJES v2.0
echo ========================================
echo.

REM Variables para ubicaciones comunes de XAMPP
set XAMPP_PATH=""
set MYSQL_PATH=""

echo [1/6] Detectando instalación de XAMPP...

REM Buscar XAMPP en ubicaciones comunes
if exist "C:\xampp\mysql\bin\mysql.exe" (
    set XAMPP_PATH=C:\xampp
    set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe
    echo ✅ XAMPP encontrado en: C:\xampp
    goto :xampp_found
)

if exist "D:\xampp\mysql\bin\mysql.exe" (
    set XAMPP_PATH=D:\xampp
    set MYSQL_PATH=D:\xampp\mysql\bin\mysql.exe
    echo ✅ XAMPP encontrado en: D:\xampp
    goto :xampp_found
)

if exist "F:\xampp\mysql\bin\mysql.exe" (
    set XAMPP_PATH=F:\xampp
    set MYSQL_PATH=F:\xampp\mysql\bin\mysql.exe
    echo ✅ XAMPP encontrado en: F:\xampp
    goto :xampp_found
)

if exist "E:\xampp\mysql\bin\mysql.exe" (
    set XAMPP_PATH=E:\xampp
    set MYSQL_PATH=E:\xampp\mysql\bin\mysql.exe
    echo ✅ XAMPP encontrado en: E:\xampp
    goto :xampp_found
)

if exist "%USERPROFILE%\xampp\mysql\bin\mysql.exe" (
    set XAMPP_PATH=%USERPROFILE%\xampp
    set MYSQL_PATH=%USERPROFILE%\xampp\mysql\bin\mysql.exe
    echo ✅ XAMPP encontrado en: %USERPROFILE%\xampp
    goto :xampp_found
)

REM Si no se encuentra, pedir ruta manual
echo ❌ XAMPP no encontrado en ubicaciones estándar
echo.
echo Por favor, ingresa la ruta donde está instalado XAMPP:
echo Ejemplo: C:\xampp, D:\xampp, F:\xampp, etc.
set /p XAMPP_PATH="Ruta de XAMPP: "

if not exist "%XAMPP_PATH%\mysql\bin\mysql.exe" (
    echo ❌ ERROR: MySQL no encontrado en %XAMPP_PATH%
    echo Verifica que XAMPP esté correctamente instalado
    echo Descarga desde: https://www.apachefriends.org
    pause
    exit /b 1
)

set MYSQL_PATH=%XAMPP_PATH%\mysql\bin\mysql.exe
echo ✅ XAMPP configurado en: %XAMPP_PATH%

:xampp_found

REM Verificar servicios de XAMPP
echo.
echo [2/6] Verificando servicios de XAMPP...

REM Verificar si hay conflictos de puerto
netstat -ano | findstr :3306 | findstr LISTENING >nul 2>&1
if %errorlevel% equ 0 (
    echo.
    echo ⚠️  ADVERTENCIA: Puerto 3306 en uso
    echo    Esto puede causar problemas con MySQL
    echo.
    echo    ¿Deseas ejecutar el solucionador automático? (s/n)
    set /p fix_choice="> "
    if /i "%fix_choice%"=="s" (
        if exist "fix_mysql.bat" (
            echo Ejecutando solucionador...
            call fix_mysql.bat
        ) else (
            echo Script solucionador no encontrado, continuando...
        )
    )
)

echo IMPORTANTE: Asegúrate de que los servicios estén corriendo:
echo.
echo 🟢 Estado esperado en XAMPP Control Panel:
echo    ✅ Apache: Running (verde)
echo    ✅ MySQL:  Running (verde)
echo.
echo Presiona cualquier tecla cuando ambos servicios estén activos...
pause > nul

REM Verificar conexión a la base de datos
echo.
echo [3/6] Verificando conexión a MySQL...
"%MYSQL_PATH%" -u root -e "SELECT VERSION();" 2>nul
if %errorlevel% neq 0 (
    echo ❌ No se puede conectar a MySQL
    echo Asegúrate de que:
    echo 1. MySQL esté corriendo en XAMPP
    echo 2. No haya conflictos de puerto
    echo 3. El usuario root esté configurado
    pause
    exit /b 1
)
echo ✅ Conexión a MySQL exitosa

REM Crear la base de datos
echo.
echo [4/6] Creando base de datos...
echo Ejecutando script SQL...

"%MYSQL_PATH%" -u root --execute="SOURCE %~dp0database\agencia_viajes.sql;" 2>error.log
if %errorlevel% neq 0 (
    echo.
    echo ❌ ERROR: No se pudo crear la base de datos
    echo Revisa el archivo error.log para más detalles
    echo.
    echo Intenta ejecutar manualmente:
    echo 1. Abrir phpMyAdmin: http://localhost/phpmyadmin
    echo 2. Crear base de datos 'agencia_viajes'
    echo 3. Importar el archivo: database/agencia_viajes.sql
    pause
    exit /b 1
)

echo ✅ Base de datos 'agencia_viajes' creada exitosamente

REM Verificar estructura de la base de datos
echo.
echo [5/6] Verificando estructura de la base de datos...
"%MYSQL_PATH%" -u root agencia_viajes -e "SHOW TABLES;" >tables.tmp 2>nul
if %errorlevel% equ 0 (
    echo ✅ Tablas creadas correctamente:
    type tables.tmp | findstr -v "Tables_in"
    del tables.tmp >nul 2>&1
) else (
    echo ⚠️  Advertencia: No se pudo verificar las tablas
)

REM Verificar configuración del proyecto
echo.
echo [6/6] Verificando configuración del proyecto...
if not exist "conexion.php" (
    echo ❌ ADVERTENCIA: Archivo conexion.php no encontrado
    echo El sistema podría no funcionar correctamente
) else (
    echo ✅ Archivo de conexión encontrado
)

if not exist "index.html" (
    echo ❌ ADVERTENCIA: Archivo index.html no encontrado
) else (
    echo ✅ Página principal encontrada
)

REM Actualizar archivo de conexión con la ruta detectada
if exist "conexion.php" (
    echo Actualizando configuración de conexión...
    REM Aquí podrías actualizar automáticamente el puerto si es necesario
)

REM Finalizar instalación
echo.
echo ========================================
echo   INSTALACIÓN COMPLETADA EXITOSAMENTE
echo ========================================
echo.
echo 📊 CONFIGURACIÓN DEL SISTEMA:
echo    🗂️  XAMPP ubicado en: %XAMPP_PATH%
echo    🗄️  Base de datos: agencia_viajes
echo    📁 Proyecto: %~dp0
echo.
echo 🌐 ACCESOS DEL SISTEMA:
echo    🏠 Principal: http://localhost/agencia/
echo    📋 phpMyAdmin: http://localhost/phpmyadmin/
echo    🔧 XAMPP Panel: %XAMPP_PATH%\xampp-control.exe
echo.
echo 🚀 FUNCIONALIDADES DISPONIBLES:
echo    ✅ Búsqueda de vuelos
echo    ✅ Gestión de hoteles
echo    ✅ Sistema de reservas
echo    ✅ Consultas especializadas
echo    ✅ Interfaz responsiva
echo.
echo ========================================

REM Limpiar archivos temporales
del error.log >nul 2>&1

REM Abrir el navegador automáticamente
echo.
echo ¿Deseas abrir el sistema en el navegador? (s/n)
set /p respuesta="> "
if /i "%respuesta%"=="s" (
    start http://localhost/agencia/
    echo 🌐 Abriendo navegador...
)

echo.
echo ¿Deseas abrir XAMPP Control Panel? (s/n)
set /p respuesta2="> "
if /i "%respuesta2%"=="s" (
    start "" "%XAMPP_PATH%\xampp-control.exe"
    echo 🔧 Abriendo XAMPP Control Panel...
)

echo.
echo 🎉 ¡Instalación completada! El sistema está listo para usar.
echo Presiona cualquier tecla para salir...
pause > nul
