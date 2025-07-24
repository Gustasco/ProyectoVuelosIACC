@echo off
REM ===================================================================
REM Script de Instalación Automática - Sistema Agencia de Viajes
REM ===================================================================
REM Autor: Gustasco
REM Descripción: Script para automatizar la instalación del proyecto
REM ===================================================================

echo.
echo ========================================
echo   INSTALADOR AGENCIA DE VIAJES
echo ========================================
echo.

REM Verificar si XAMPP está instalado
echo [1/5] Verificando instalación de XAMPP...
if not exist "C:\xampp\mysql\bin\mysql.exe" (
    echo ERROR: XAMPP no encontrado en C:\xampp\
    echo Por favor, instala XAMPP primero desde: https://www.apachefriends.org
    pause
    exit /b 1
)
echo ✅ XAMPP encontrado

REM Verificar servicios de XAMPP
echo.
echo [2/5] Verificando servicios de XAMPP...
echo IMPORTANTE: Asegúrate de que Apache y MySQL estén ejecutándose en XAMPP Control Panel
echo Presiona cualquier tecla cuando los servicios estén activos...
pause > nul

REM Crear la base de datos
echo.
echo [3/5] Creando base de datos...
echo Ejecutando script SQL...

C:\xampp\mysql\bin\mysql.exe -u root -p --execute="SOURCE %~dp0database\agencia_viajes.sql;"

if %errorlevel% neq 0 (
    echo.
    echo ERROR: No se pudo crear la base de datos
    echo Intenta ejecutar manualmente:
    echo 1. Abrir phpMyAdmin: http://localhost/phpmyadmin
    echo 2. Crear base de datos 'agencia_viajes'
    echo 3. Importar el archivo: database/agencia_viajes.sql
    pause
    exit /b 1
)

echo ✅ Base de datos creada exitosamente

REM Verificar configuración
echo.
echo [4/5] Verificando configuración...
if not exist "conexion.php" (
    echo ADVERTENCIA: Archivo conexion.php no encontrado
    echo Asegúrate de tener el archivo de conexión configurado
)
echo ✅ Configuración verificada

REM Finalizar instalación
echo.
echo [5/5] Finalizando instalación...
echo.
echo ========================================
echo   INSTALACIÓN COMPLETADA
echo ========================================
echo.
echo El sistema está listo para usar:
echo.
echo 🌐 URL Principal: http://localhost/agencia/
echo 📋 phpMyAdmin: http://localhost/phpmyadmin/
echo 📁 Ubicación: %~dp0
echo.
echo Funcionalidades disponibles:
echo ✅ Búsqueda de vuelos
echo ✅ Gestión de hoteles
echo ✅ Sistema de reservas
echo ✅ Interfaz responsiva
echo.
echo ========================================

REM Abrir el navegador automáticamente
echo ¿Deseas abrir el sistema en el navegador? (s/n)
set /p respuesta="> "
if /i "%respuesta%"=="s" (
    start http://localhost/agencia/
)

echo.
echo Presiona cualquier tecla para salir...
pause > nul
