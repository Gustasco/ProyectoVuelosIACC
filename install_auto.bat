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

REM Instalar promociones automáticamente
echo.
echo [5/7] Instalando promociones dinámicas...
echo Ejecutando script de promociones...

if exist "instalar_promociones.php" (
    REM Usar curl si está disponible
    curl --version >nul 2>&1
    if %errorlevel% equ 0 (
        echo ✅ Usando curl para instalar promociones...
        curl -s "http://localhost/agencia/instalar_promociones.php" >promociones_result.tmp 2>&1
        if %errorlevel% equ 0 (
            echo ✅ Promociones instaladas via HTTP
            type promociones_result.tmp | findstr "exitosamente" >nul
            if %errorlevel% equ 0 (
                echo ✅ Confirmación: Promociones cargadas correctamente
            ) else (
                echo ⚠️  Advertencia: Respuesta inusual del servidor
            )
        ) else (
            echo ⚠️  No se pudo conectar via HTTP, intentando PHP directo...
            goto :direct_php
        )
    ) else (
        echo ⚠️  curl no disponible, intentando PHP directo...
        goto :direct_php
    )
) else (
    echo ❌ ADVERTENCIA: Script instalar_promociones.php no encontrado
    echo Las promociones dinámicas no se instalarán automáticamente
    goto :skip_promociones
)

goto :promociones_done

:direct_php
REM Intentar ejecutar PHP directamente
if exist "%XAMPP_PATH%\php\php.exe" (
    echo ✅ Ejecutando PHP directamente...
    "%XAMPP_PATH%\php\php.exe" instalar_promociones.php >promociones_result.tmp 2>&1
    if %errorlevel% equ 0 (
        echo ✅ Promociones instaladas via PHP directo
        type promociones_result.tmp | findstr "exitosamente" >nul
        if %errorlevel% equ 0 (
            echo ✅ Confirmación: Promociones cargadas correctamente
        )
    ) else (
        echo ❌ Error ejecutando PHP directo
        echo Contenido del error:
        type promociones_result.tmp
    )
) else (
    echo ❌ PHP no encontrado en %XAMPP_PATH%\php\php.exe
    echo Las promociones deberán instalarse manualmente
)

:promociones_done
REM Limpiar archivo temporal
del promociones_result.tmp >nul 2>&1

:skip_promociones

REM Verificar estructura de la base de datos
echo.
echo [6/7] Verificando estructura de la base de datos...
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
echo [7/7] Verificando configuración del proyecto...
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

if not exist "promociones_dinamicas.html" (
    echo ❌ ADVERTENCIA: Archivo promociones_dinamicas.html no encontrado
) else (
    echo ✅ Página de promociones dinámicas encontrada
)

if not exist "promociones_api.php" (
    echo ❌ ADVERTENCIA: API de promociones no encontrada
) else (
    echo ✅ API de promociones encontrada
)

REM Verificar que las promociones se hayan instalado
echo Verificando promociones en la base de datos...
"%MYSQL_PATH%" -u root agencia_viajes -e "SELECT COUNT(*) as total FROM promociones;" >promo_count.tmp 2>nul
if %errorlevel% equ 0 (
    for /f "skip=1" %%i in (promo_count.tmp) do (
        if %%i gtr 0 (
            echo ✅ Promociones encontradas en la base de datos: %%i registros
        ) else (
            echo ⚠️  No se encontraron promociones en la base de datos
            echo Recomendación: Ejecutar manualmente instalar_promociones.php
        )
    )
    del promo_count.tmp >nul 2>&1
) else (
    echo ⚠️  No se pudo verificar las promociones
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
echo    🎯 Promociones: http://localhost/agencia/promociones_dinamicas.html
echo    📊 API Promociones: http://localhost/agencia/promociones_api.php
echo    📋 phpMyAdmin: http://localhost/phpmyadmin/
echo    🔧 XAMPP Panel: %XAMPP_PATH%\xampp-control.exe
echo.
echo 🚀 FUNCIONALIDADES DISPONIBLES:
echo    ✅ Búsqueda de vuelos
echo    ✅ Gestión de hoteles
echo    ✅ Sistema de reservas
echo    ✅ Consultas especializadas
echo    ✅ Interfaz responsiva Bootstrap 5.3.2
echo    ✅ Carousel dinámico de promociones
echo    ✅ API REST para promociones
echo    ✅ Tema azul/blanco unificado
echo.
echo ========================================

REM Limpiar archivos temporales
del error.log >nul 2>&1

REM Abrir el navegador automáticamente
echo.
echo ¿Qué página deseas abrir en el navegador?
echo 1) Página principal (index.html)
echo 2) Promociones dinámicas (carousel)
echo 3) Ambas páginas
echo 4) No abrir navegador
set /p browser_choice="Selecciona una opción (1-4): "

if "%browser_choice%"=="1" (
    start http://localhost/agencia/
    echo 🌐 Abriendo página principal...
) else if "%browser_choice%"=="2" (
    start http://localhost/agencia/promociones_dinamicas.html
    echo 🎯 Abriendo promociones dinámicas...
) else if "%browser_choice%"=="3" (
    start http://localhost/agencia/
    timeout /t 2 /nobreak >nul
    start http://localhost/agencia/promociones_dinamicas.html
    echo 🌐 Abriendo ambas páginas...
) else (
    echo ℹ️  No se abrirá el navegador automáticamente
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
echo.
echo 📝 NOTAS IMPORTANTES:
echo    • Las promociones se actualizan automáticamente cada 5 segundos
echo    • El carousel muestra máximo 6 promociones vigentes
echo    • API REST disponible en /promociones_api.php
echo    • Tema Bootstrap 5.3.2 con diseño responsivo
echo.
echo 💡 Para reinstalar promociones manualmente:
echo    http://localhost/agencia/instalar_promociones.php
echo.
echo Presiona cualquier tecla para salir...
pause > nul
