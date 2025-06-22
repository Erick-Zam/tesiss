#!/bin/bash

# Script para cambiar la configuración entre entornos de desarrollo y producción

MODE=$1

if [ "$MODE" = "prod" ] || [ "$MODE" = "production" ]; then
    # Configuración para entorno de producción (Awardspace)
    sed -i 's/define(.DB_HOST., .localhost.)/define(\'DB_HOST\', \'fdb1030.awardspace.net\')/' config.php
    sed -i 's/define(.DB_USER., .erick.)/define(\'DB_USER\', \'4550502_prueba\')/' config.php
    sed -i 's/define(.DB_PASS., .Evimu997261.)/define(\'DB_PASS\', \'Hosting28147*\')/' config.php
    echo "Configuración cambiada a entorno de PRODUCCIÓN"
    
elif [ "$MODE" = "dev" ] || [ "$MODE" = "development" ]; then
    # Configuración para entorno de desarrollo local
    sed -i 's/define(.DB_HOST., .fdb1030.awardspace.net.)/define(\'DB_HOST\', \'localhost\')/' config.php
    sed -i 's/define(.DB_USER., .4550502_prueba.)/define(\'DB_USER\', \'erick\')/' config.php
    sed -i 's/define(.DB_PASS., .Hosting28147\*.)/define(\'DB_PASS\', \'Evimu997261\')/' config.php
    echo "Configuración cambiada a entorno de DESARROLLO"
    
else
    echo "Uso: $0 [prod|dev]"
    echo "  prod: Configura para entorno de producción (Awardspace)"
    echo "  dev: Configura para entorno de desarrollo local"
    exit 1
fi

# Limpiar caché
if [ -d "cache" ]; then
    rm -rf cache/*
fi

echo "¡Configuración completada!"
