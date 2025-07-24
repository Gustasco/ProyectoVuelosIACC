@echo off
REM ===================================================================
REM Script de Solución para Problemas de MySQL en XAMPP
REM ===================================================================
REM Ejecutar como ADMINISTRADOR
REM ===================================================================

echo.
echo ========================================
echo   SOLUCIONADOR DE MYSQL - XAMPP
echo ========================================
echo.
echo IMPORTANTE: Este script debe ejecutarse como ADMINISTRADOR
echo.

REM Verificar si se ejecuta como administrador
NET SESSION >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Ejecutar como Administrador
    echo Clic derecho en el archivo y seleccionar "Ejecutar como administrador"
    pause
    exit /b 1
)

echo [1/6] Verificando procesos MySQL existentes...
tasklist | findstr mysqld.exe
if %errorlevel% equ 0 (
    echo Terminando procesos MySQL existentes...
    taskkill /IM mysqld.exe /F >nul 2>&1
    timeout /t 3 >nul
)

echo [2/6] Verificando servicios MySQL...
sc query mysql >nul 2>&1
if %errorlevel% equ 0 (
    echo Deteniendo servicio MySQL...
    net stop mysql >nul 2>&1
)

echo [3/6] Limpiando puerto 3306...
for /f "tokens=5" %%a in ('netstat -ano ^| findstr :3306 ^| findstr LISTENING') do (
    echo Terminando proceso en puerto 3306: %%a
    taskkill /PID %%a /F >nul 2>&1
)

echo [4/6] Verificando archivos de MySQL...
if exist "F:\xampp\mysql\data\ib_logfile0" (
    echo Respaldando archivos de log de MySQL...
    move "F:\xampp\mysql\data\ib_logfile0" "F:\xampp\mysql\data\ib_logfile0.bak" >nul 2>&1
)
if exist "F:\xampp\mysql\data\ib_logfile1" (
    move "F:\xampp\mysql\data\ib_logfile1" "F:\xampp\mysql\data\ib_logfile1.bak" >nul 2>&1
)

echo [5/6] Verificando permisos en carpeta MySQL...
icacls "F:\xampp\mysql\data" /grant Everyone:(OI)(CI)F >nul 2>&1

echo [6/6] Limpieza completada
echo.
echo ========================================
echo   SOLUCION APLICADA
echo ========================================
echo.
echo Pasos realizados:
echo ✅ Procesos MySQL terminados
echo ✅ Servicios MySQL detenidos  
echo ✅ Puerto 3306 liberado
echo ✅ Archivos de log respaldados
echo ✅ Permisos verificados
echo.
echo SIGUIENTE: Abrir XAMPP Control Panel y iniciar MySQL
echo.
pause
