# 🚀 Configuración Rápida de INNOVADENT

## Problema Actual
El sistema está intentando acceder a `http://localhost/innovadent` en lugar de `http://innovadent.local`

## ✅ Solución Paso a Paso

### 1. Configurar el archivo hosts

Edita el archivo hosts de tu sistema:

**En Linux/Mac:**
```bash
sudo nano /etc/hosts
```

**En Windows:**
```
C:\Windows\System32\drivers\etc\hosts
```

Agrega esta línea:
```
127.0.0.1    innovadent.local
```

Guarda el archivo (Ctrl+O, Enter, Ctrl+X en nano).

---

### 2. Configurar Virtual Host en Apache

**Opción A - Copiar archivo de configuración:**

```bash
# Copiar el archivo de configuración
sudo cp /home/user/innovadent/innovadent.local.conf /etc/apache2/sites-available/

# Habilitar el sitio
sudo a2ensite innovadent.local.conf

# Habilitar mod_rewrite si no está habilitado
sudo a2enmod rewrite

# Reiniciar Apache
sudo systemctl restart apache2
```

**Opción B - Crear manualmente:**

Crea el archivo `/etc/apache2/sites-available/innovadent.local.conf`:

```apache
<VirtualHost *:80>
    ServerName innovadent.local
    ServerAlias www.innovadent.local

    DocumentRoot /home/user/innovadent/public

    <Directory /home/user/innovadent/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/innovadent-error.log
    CustomLog ${APACHE_LOG_DIR}/innovadent-access.log combined

    php_value upload_max_filesize 10M
    php_value post_max_size 10M
    php_value max_execution_time 300
    php_value memory_limit 256M
</VirtualHost>
```

Luego ejecuta:
```bash
sudo a2ensite innovadent.local.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

### 3. Verificar permisos de carpetas

```bash
cd /home/user/innovadent

# Dar permisos a las carpetas de storage y uploads
sudo chmod -R 775 storage/
sudo chmod -R 775 public/uploads/

# Cambiar propietario a www-data (usuario de Apache)
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data public/uploads/
```

---

### 4. Verificar la configuración de la base de datos

Edita `/home/user/innovadent/app/config/config.php` y verifica:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'innovadent');
define('DB_USER', 'root');  // Tu usuario MySQL
define('DB_PASS', '');      // Tu contraseña MySQL
```

---

### 5. Importar la base de datos (si no lo has hecho)

```bash
mysql -u root -p innovadent < /home/user/innovadent/database/schema.sql
```

O desde phpMyAdmin:
1. Crea la base de datos `innovadent`
2. Importa el archivo `database/schema.sql`

---

### 6. Verificar que Apache tiene mod_rewrite habilitado

```bash
# Verificar módulos habilitados
apache2ctl -M | grep rewrite

# Si no aparece, habilitarlo:
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

### 7. Limpiar caché del navegador

Después de todos los cambios:
1. Cierra todas las ventanas del navegador
2. Abre el navegador en modo incógnito
3. Accede a: `http://innovadent.local`

---

## 🔍 Verificación

### Prueba que todo funciona:

1. **Accede al sistema:**
   ```
   http://innovadent.local
   ```
   Debería redirigirte automáticamente a la página de login.

2. **Inicia sesión con las credenciales por defecto:**
   - Usuario: `admin`
   - Contraseña: `admin123`

3. **Accede al Portal del Paciente:**
   ```
   http://innovadent.local/portal
   ```

4. **Accede a la API:**
   ```
   http://innovadent.local/api.php?endpoint=auth&action=login
   ```

---

## 🐛 Solución de Problemas

### Problema: "Página no encontrada" o Error 404

**Causa:** mod_rewrite no está habilitado o .htaccess no está siendo leído.

**Solución:**
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Verifica que en el VirtualHost tengas:
```apache
AllowOverride All
```

---

### Problema: "Forbidden - No tienes permiso para acceder"

**Causa:** Permisos incorrectos.

**Solución:**
```bash
sudo chown -R www-data:www-data /home/user/innovadent
sudo chmod -R 755 /home/user/innovadent
sudo chmod -R 775 /home/user/innovadent/storage
sudo chmod -R 775 /home/user/innovadent/public/uploads
```

---

### Problema: Error de conexión a base de datos

**Causa:** Credenciales incorrectas o base de datos no creada.

**Solución:**
```bash
# Crear base de datos
mysql -u root -p
CREATE DATABASE innovadent CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Importar schema
mysql -u root -p innovadent < /home/user/innovadent/database/schema.sql
```

---

### Problema: Estilos no cargan (sin CSS)

**Causa:** Ruta incorrecta a archivos estáticos.

**Solución:**
1. Verifica que `APP_URL` en `config.php` sea: `http://innovadent.local`
2. Limpia caché del navegador
3. Abre la consola del navegador (F12) y verifica errores

---

## 📝 Configuración Alternativa (si usas XAMPP/WAMP)

Si usas XAMPP o WAMP:

1. Copia la carpeta `innovadent` a `C:\xampp\htdocs\` o `C:\wamp64\www\`

2. Edita `C:\xampp\apache\conf\extra\httpd-vhosts.conf` y agrega:

```apache
<VirtualHost *:80>
    ServerName innovadent.local
    DocumentRoot "C:/xampp/htdocs/innovadent/public"
    <Directory "C:/xampp/htdocs/innovadent/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Edita `C:\Windows\System32\drivers\etc\hosts` (como administrador) y agrega:
```
127.0.0.1    innovadent.local
```

4. Reinicia Apache desde el panel de XAMPP

---

## ✅ Checklist de Verificación

- [ ] Archivo hosts configurado con `127.0.0.1 innovadent.local`
- [ ] Virtual host de Apache creado y habilitado
- [ ] mod_rewrite habilitado en Apache
- [ ] Apache reiniciado
- [ ] Permisos de carpetas configurados
- [ ] Base de datos creada e importada
- [ ] `APP_URL` en config.php = `http://innovadent.local`
- [ ] Caché del navegador limpiada
- [ ] Acceso a `http://innovadent.local` funciona

---

## 📞 Soporte

Si después de seguir estos pasos sigues teniendo problemas:

1. Revisa los logs de Apache:
   ```bash
   sudo tail -f /var/log/apache2/innovadent-error.log
   sudo tail -f /var/log/apache2/error.log
   ```

2. Verifica la configuración de PHP:
   ```bash
   php -v
   php -m | grep pdo
   ```

3. Prueba acceder directamente a:
   ```
   http://innovadent.local/index.php
   ```

---

## 🎉 ¡Listo!

Una vez configurado, accede a:

**Panel Administrativo:**
- URL: http://innovadent.local
- Usuario: admin
- Contraseña: admin123

**Portal del Paciente:**
- URL: http://innovadent.local/portal

**API REST:**
- URL: http://innovadent.local/api.php
- Documentación: Ver API_DOCUMENTATION.md
