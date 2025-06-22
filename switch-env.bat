@echo off
REM Script para cambiar la configuración entre entornos de desarrollo y producción

SET MODE=%1

IF "%MODE%"=="prod" (
    GOTO PROD
) ELSE IF "%MODE%"=="production" (
    GOTO PROD
) ELSE IF "%MODE%"=="dev" (
    GOTO DEV
) ELSE IF "%MODE%"=="development" (
    GOTO DEV
) ELSE (
    GOTO USAGE
)

:PROD
REM Configuración para entorno de producción (Awardspace)
powershell -Command "(Get-Content config.php) -replace 'define\(''DB_HOST'', ''localhost''\)', 'define(''DB_HOST'', ''fdb1030.awardspace.net'')' | Set-Content config.php"
powershell -Command "(Get-Content config.php) -replace 'define\(''DB_USER'', ''erick''\)', 'define(''DB_USER'', ''4550502_prueba'')' | Set-Content config.php"
powershell -Command "(Get-Content config.php) -replace 'define\(''DB_PASS'', ''Evimu997261''\)', 'define(''DB_PASS'', ''Hosting28147*'')' | Set-Content config.php"
echo Configuración cambiada a entorno de PRODUCCIÓN
GOTO END

:DEV
REM Configuración para entorno de desarrollo local
powershell -Command "(Get-Content config.php) -replace 'define\(''DB_HOST'', ''fdb1030.awardspace.net''\)', 'define(''DB_HOST'', ''localhost'')' | Set-Content config.php"
powershell -Command "(Get-Content config.php) -replace 'define\(''DB_USER'', ''4550502_prueba''\)', 'define(''DB_USER'', ''erick'')' | Set-Content config.php"
powershell -Command "(Get-Content config.php) -replace 'define\(''DB_PASS'', ''Hosting28147\*''\)', 'define(''DB_PASS'', ''Evimu997261'')' | Set-Content config.php"
echo Configuración cambiada a entorno de DESARROLLO
GOTO END

:USAGE
echo Uso: %0 [prod^|dev]
echo   prod: Configura para entorno de producción (Awardspace)
echo   dev: Configura para entorno de desarrollo local
exit /b 1

:END
REM Limpiar caché
if exist cache (
    del /q cache\*
)

echo ¡Configuración completada!
