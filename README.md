# Arrocera Familia y Maria - Sistema de Gestión

## Instrucciones de Despliegue

Este documento explica cómo desplegar correctamente la aplicación en diferentes entornos.

### Requisitos del Servidor

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web Apache con mod_rewrite habilitado

### Pasos para el Despliegue

1. **Configuración de la Base de Datos**

   La configuración de la conexión a la base de datos está centralizada en el archivo `config.php`. 
   Modifique este archivo según el entorno donde vaya a desplegar la aplicación:

   ```php
   // Para despliegue en hosting Awardspace
   define('DB_HOST', 'fdb1030.awardspace.net');
   define('DB_USER', '4550502_prueba');
   define('DB_PASS', 'Hosting28147*');
   
   // Para despliegue en servidor local
   define('DB_HOST', 'localhost');
   define('DB_USER', 'erick');
   define('DB_PASS', 'Evimu997261');
   ```

2. **Instalación de Dependencias de Composer**

   La aplicación utiliza la biblioteca de generación de códigos de barras de Picqer. Para instalarla:

   ```bash
   composer install
   ```

3. **Permisos de Archivos**

   En un servidor Linux, asegúrese de configurar correctamente los permisos:

   ```bash
   chmod 755 -R /ruta/a/su/app
   chown www-data:www-data -R /ruta/a/su/app
   ```

4. **Configuración del Servidor Web**

   Asegúrese de que el directorio raíz del servidor web apunte a la carpeta principal de la aplicación.

   **Ejemplo de configuración de VirtualHost para Apache:**

   ```apache
   <VirtualHost *:80>
       ServerName sudominio.com
       DocumentRoot /ruta/a/su/app
       
       <Directory /ruta/a/su/app>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/error.log
       CustomLog ${APACHE_LOG_DIR}/access.log combined
   </VirtualHost>
   ```

5. **Configuración de SSL (opcional pero recomendado)**

   Para configurar HTTPS con Let's Encrypt:

   ```bash
   sudo certbot --apache -d sudominio.com
   ```

### Estructura de la Aplicación

- `config.php`: Configuración centralizada de la base de datos
- `index.php`: Punto de entrada principal
- `php/`: Carpeta con scripts de backend
- `vendor/`: Dependencias de Composer
- `css/`: Estilos de la aplicación
- `js/`: Scripts JavaScript
- `img/`: Imágenes utilizadas en la aplicación

### Solución de Problemas

Si encuentra problemas durante el despliegue:

1. Verifique los logs de error de PHP: `/var/log/apache2/error.log`
2. Asegúrese de que la base de datos esté accesible desde el servidor
3. Compruebe que las credenciales de la base de datos sean correctas
4. Verifique que el servidor web tenga los permisos adecuados para los archivos

Para obtener ayuda adicional, contacte al desarrollador: [correo@ejemplo.com]
