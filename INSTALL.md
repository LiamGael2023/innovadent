# INNOVADENT - Guía de Instalación PHP MVC

## Requisitos del Sistema

### Software Requerido
- **PHP**: 7.4 o superior (recomendado 8.0+)
- **MySQL**: 5.7 o superior (recomendado 8.0+)
- **Apache**: 2.4 o superior con mod_rewrite habilitado
- **Composer** (opcional): Para gestión de dependencias futuras

### Extensiones PHP Requeridas
- PDO
- pdo_mysql
- mbstring
- openssl
- json
- fileinfo

## Pasos de Instalación

### 1. Clonar o Descargar el Proyecto

```bash
git clone https://github.com/tu-usuario/innovadent.git
cd innovadent
```

### 2. Configurar el Servidor Web

#### Apache con VirtualHost

Crear un archivo de configuración en `/etc/apache2/sites-available/innovadent.conf`:

```apache
<VirtualHost *:80>
    ServerName innovadent.local
    DocumentRoot /ruta/a/innovadent/public

    <Directory /ruta/a/innovadent/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/innovadent-error.log
    CustomLog ${APACHE_LOG_DIR}/innovadent-access.log combined
</VirtualHost>
```

Habilitar el sitio y mod_rewrite:

```bash
sudo a2ensite innovadent.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Agregar a `/etc/hosts`:

```
127.0.0.1   innovadent.local
```

#### Nginx (alternativo)

```nginx
server {
    listen 80;
    server_name innovadent.local;
    root /ruta/a/innovadent/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 3. Configurar la Base de Datos

#### Crear la Base de Datos

Importar el schema SQL:

```bash
mysql -u root -p < database/schema.sql
```

O manualmente:

```sql
mysql -u root -p
CREATE DATABASE innovadent CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE innovadent;
SOURCE /ruta/a/innovadent/database/schema.sql;
```

### 4. Configurar el Archivo de Configuración

Editar `app/config/config.php`:

```php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'innovadent');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');

// URL de la aplicación
define('APP_URL', 'http://innovadent.local');

// Modo de desarrollo (cambiar a 'production' en producción)
define('APP_ENV', 'development');
```

### 5. Configurar Permisos

```bash
# Permisos para directorios de storage
chmod -R 775 storage/logs
chmod -R 775 storage/cache
chmod -R 775 storage/sessions
chmod -R 775 public/uploads

# Propietario (ajustar según tu servidor)
chown -R www-data:www-data storage/
chown -R www-data:www-data public/uploads/
```

### 6. Acceder al Sistema

Abrir en el navegador:

```
http://innovadent.local
```

**Credenciales por defecto:**
- Usuario: `admin`
- Contraseña: `admin123`

⚠️ **IMPORTANTE**: Cambiar la contraseña del administrador inmediatamente.

## Estructura del Proyecto

```
innovadent/
│
├── app/
│   ├── config/          # Archivos de configuración
│   ├── controllers/     # Controladores MVC
│   ├── core/            # Clases base (Database, Model, Controller, Router)
│   ├── models/          # Modelos de datos
│   ├── views/           # Vistas (HTML/PHP)
│   ├── helpers/         # Funciones auxiliares
│   └── middleware/      # Middleware (autenticación, etc.)
│
├── public/              # Directorio público (punto de entrada)
│   ├── css/             # Estilos CSS
│   ├── js/              # JavaScript
│   ├── images/          # Imágenes
│   ├── uploads/         # Archivos subidos
│   ├── index.php        # Punto de entrada
│   └── .htaccess        # Configuración Apache
│
├── database/
│   ├── schema.sql       # Schema de base de datos
│   ├── migrations/      # Migraciones
│   └── seeds/           # Datos de prueba
│
├── storage/
│   ├── logs/            # Logs del sistema
│   ├── cache/           # Archivos de caché
│   └── sessions/        # Sesiones
│
├── .htaccess            # Redirección a public/
├── README.md            # Documentación general
└── INSTALL.md           # Esta guía
```

## Configuración Avanzada

### Entorno de Producción

1. **Cambiar modo a producción** en `config.php`:
   ```php
   define('APP_ENV', 'production');
   ```

2. **Deshabilitar errores** en `config.php`:
   ```php
   error_reporting(0);
   ini_set('display_errors', 0);
   ```

3. **Configurar SSL/HTTPS**:
   ```apache
   <VirtualHost *:443>
       ServerName innovadent.com
       SSLEngine on
       SSLCertificateFile /path/to/cert.pem
       SSLCertificateKeyFile /path/to/key.pem
       # ... resto de configuración
   </VirtualHost>
   ```

4. **Configurar backups automáticos**:
   ```bash
   # Crontab para backup diario
   0 2 * * * mysqldump -u usuario -p'contraseña' innovadent > /backups/innovadent_$(date +\%Y\%m\%d).sql
   ```

### Email Configuration

Configurar en `config.php`:

```php
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'tu-email@gmail.com');
define('MAIL_PASSWORD', 'tu-app-password');
```

## Solución de Problemas

### Error 404 en todas las rutas

**Problema**: Mod_rewrite no está habilitado.

**Solución**:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Error de conexión a la base de datos

**Problema**: Credenciales incorrectas o MySQL no está corriendo.

**Solución**:
1. Verificar que MySQL esté corriendo: `sudo systemctl status mysql`
2. Verificar credenciales en `config.php`
3. Verificar que el usuario tenga permisos: `GRANT ALL PRIVILEGES ON innovadent.* TO 'usuario'@'localhost';`

### Error de permisos en archivos

**Problema**: Apache no puede escribir en `storage/` o `uploads/`.

**Solución**:
```bash
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/
```

### Sesiones no funcionan

**Problema**: Directorio de sesiones no tiene permisos.

**Solución**:
```bash
mkdir -p storage/sessions
chmod 775 storage/sessions
chown www-data:www-data storage/sessions
```

## Actualización del Sistema

Para actualizar a una nueva versión:

```bash
# 1. Hacer backup de la base de datos
mysqldump -u usuario -p innovadent > backup.sql

# 2. Hacer backup de archivos
tar -czf innovadent_backup.tar.gz app/ public/ database/

# 3. Descargar nueva versión
git pull origin main

# 4. Ejecutar migraciones si existen
mysql -u usuario -p innovadent < database/migrations/nueva_migracion.sql

# 5. Limpiar caché
rm -rf storage/cache/*
```

## Seguridad

### Cambios Recomendados en Producción

1. **Cambiar la clave de cifrado** en `config.php`:
   ```php
   define('ENCRYPTION_KEY', 'generar-una-clave-aleatoria-segura');
   ```

2. **Restringir acceso a directorios**:
   ```apache
   <Directory /ruta/a/innovadent>
       Order Deny,Allow
       Deny from all
   </Directory>

   <Directory /ruta/a/innovadent/public>
       Order Allow,Deny
       Allow from all
   </Directory>
   ```

3. **Configurar firewall**:
   ```bash
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw enable
   ```

4. **Actualizar contraseñas por defecto**

5. **Configurar 2FA para usuarios administradores**

## Soporte

- **Documentación**: Ver `README.md` y `SYSTEM_DESIGN.md`
- **Issues**: Reportar en GitHub
- **Email**: soporte@innovadent.com

## Licencia

MIT License - Ver archivo LICENSE para más detalles.

---

**INNOVADENT** - Sistema de Gestión Dental
Versión 1.0.0 - © 2025
