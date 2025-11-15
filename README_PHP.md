# INNOVADENT PHP MVC 🦷

## Sistema Integral de Gestión para Clínicas Dentales

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql)
![License](https://img.shields.io/badge/license-MIT-green.svg)

**INNOVADENT** es un sistema completo de gestión clínica dental desarrollado en PHP puro utilizando el patrón MVC (Modelo-Vista-Controlador). Diseñado para optimizar todos los procesos administrativos, clínicos y financieros de clínicas dentales modernas.

---

## 🚀 Características Principales

### ✅ Implementado en esta Versión

- **✓ Sistema MVC Completo**: Arquitectura limpia y escalable
- **✓ Autenticación de Usuarios**: Login seguro con hash de contraseñas
- **✓ Gestión de Pacientes**: CRUD completo con historial médico
- **✓ Agenda de Citas**: Calendario, recordatorios y estados
- **✓ Dashboard Interactivo**: Estadísticas en tiempo real
- **✓ Sistema de Roles**: Control de acceso basado en roles
- **✓ Base de Datos Optimizada**: 76 tablas normalizadas
- **✓ Interfaz Moderna**: Bootstrap 5 y Font Awesome
- **✓ Responsive Design**: Adaptable a todos los dispositivos
- **✓ Validación de Datos**: Sanitización y validación robusta
- **✓ Gestión de Sesiones**: Control seguro de sesiones
- **✓ Paginación**: Sistema de paginación integrado

### 📋 Módulos Disponibles

1. **Autenticación** ✅
   - Login/Logout
   - Gestión de sesiones
   - Verificación de roles

2. **Dashboard** ✅
   - Estadísticas generales
   - Citas del día
   - Accesos rápidos

3. **Pacientes** ✅
   - Lista con búsqueda y paginación
   - Ficha completa del paciente
   - Historia clínica digital
   - Documentos y fotos

4. **Citas** ✅
   - Agenda visual
   - Creación y edición
   - Estados de citas
   - Verificación de disponibilidad

5. **Tratamientos** (Base implementada)
   - Catálogo de tratamientos
   - Categorías
   - Precios y duraciones

6. **Facturación** (Base implementada)
   - Facturación básica
   - Métodos de pago
   - Historial de pagos

---

## 📦 Requisitos del Sistema

### Software Necesario

| Software | Versión Mínima | Recomendada |
|----------|---------------|-------------|
| PHP | 7.4 | 8.0+ |
| MySQL | 5.7 | 8.0+ |
| Apache | 2.4 | 2.4+ |
| mod_rewrite | Habilitado | Habilitado |

### Extensiones PHP

- PDO
- pdo_mysql
- mbstring
- openssl
- json
- fileinfo

---

## 🔧 Instalación Rápida

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/innovadent.git
cd innovadent
```

### 2. Importar Base de Datos

```bash
mysql -u root -p < database/schema.sql
```

### 3. Configurar

Editar `app/config/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'innovadent');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('APP_URL', 'http://localhost/innovadent');
```

### 4. Configurar Permisos

```bash
chmod -R 775 storage/
chmod -R 775 public/uploads/
```

### 5. Acceder al Sistema

```
http://localhost/innovadent
```

**Credenciales por defecto:**
- Usuario: `admin`
- Contraseña: `admin123`

📖 **Guía Completa**: Ver [INSTALL.md](INSTALL.md)

---

## 🏗️ Arquitectura del Sistema

### Patrón MVC

```
┌─────────────┐
│   USUARIO   │
└─────┬───────┘
      │
      ▼
┌─────────────┐      ┌──────────────┐      ┌─────────────┐
│   ROUTER    │─────▶│ CONTROLLER   │─────▶│    MODEL    │
└─────────────┘      └──────┬───────┘      └─────┬───────┘
                            │                    │
                            ▼                    ▼
                     ┌──────────────┐      ┌─────────────┐
                     │     VIEW     │      │  DATABASE   │
                     └──────────────┘      └─────────────┘
```

### Estructura de Directorios

```
innovadent/
├── app/
│   ├── config/              # Configuración
│   │   └── config.php       # Configuración principal
│   ├── core/                # Núcleo del framework
│   │   ├── Database.php     # Conexión PDO
│   │   ├── Model.php        # Clase base de modelos
│   │   ├── Controller.php   # Clase base de controladores
│   │   └── Router.php       # Sistema de rutas
│   ├── controllers/         # Controladores
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── PatientsController.php
│   │   └── AppointmentsController.php
│   ├── models/              # Modelos
│   │   ├── User.php
│   │   ├── Patient.php
│   │   └── Appointment.php
│   └── views/               # Vistas
│       ├── layouts/
│       ├── auth/
│       ├── dashboard/
│       ├── patients/
│       └── appointments/
├── public/                  # Archivos públicos
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── uploads/
│   ├── index.php           # Punto de entrada
│   └── .htaccess
├── database/
│   ├── schema.sql          # Schema MySQL completo
│   ├── migrations/
│   └── seeds/
├── storage/
│   ├── logs/
│   ├── cache/
│   └── sessions/
└── README_PHP.md           # Este archivo
```

---

## 🗄️ Base de Datos

### Tablas Principales

El sistema cuenta con **76 tablas** organizadas en 11 módulos:

#### Módulo de Configuración
- `clinics` - Clínicas/Sucursales
- `users` - Usuarios del sistema
- `roles` - Roles de usuario
- `user_roles` - Asignación de roles

#### Módulo de Pacientes
- `patients` - Información de pacientes
- `medical_histories` - Historia clínica
- `patient_contacts` - Contactos de emergencia
- `patient_insurances` - Seguros médicos

#### Módulo de Citas
- `appointments` - Citas agendadas
- `appointment_types` - Tipos de cita
- `appointment_reminders` - Recordatorios

#### Módulo de Tratamientos
- `treatment_categories` - Categorías
- `treatments` - Catálogo de tratamientos
- `treatment_materials` - Materiales

#### Módulo de Facturación
- `invoices` - Facturas
- `invoice_items` - Ítems de factura
- `payments` - Pagos
- `payment_methods` - Formas de pago

📊 **Schema Completo**: Ver [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)

---

## 🎨 Interfaz de Usuario

### Tecnologías Frontend

- **Bootstrap 5.3**: Framework CSS
- **Font Awesome 6.4**: Iconos
- **jQuery 3.7**: Manipulación DOM
- **Chart.js**: Gráficos (próximamente)

### Capturas de Pantalla

#### Login
- Sistema de autenticación moderno
- Validación de credenciales
- Diseño responsive

#### Dashboard
- Estadísticas en tiempo real
- Citas del día
- Accesos rápidos
- Gráficos visuales

#### Gestión de Pacientes
- Lista con búsqueda
- Paginación
- Ficha completa
- Historial médico

---

## 🔐 Seguridad

### Características de Seguridad Implementadas

✅ **Hash de Contraseñas**: bcrypt con cost 12
✅ **Prepared Statements**: Protección contra SQL Injection
✅ **Sanitización de Datos**: Limpieza de inputs
✅ **Validación de Sesiones**: Control de acceso
✅ **HTTPS Ready**: Preparado para SSL
✅ **CSRF Protection**: Tokens (próximamente)
✅ **XSS Prevention**: Escape de HTML

### Recomendaciones de Producción

1. **Cambiar contraseñas por defecto**
2. **Habilitar HTTPS**
3. **Configurar firewall**
4. **Backups automáticos**
5. **Actualizar regularmente**

---

## 📊 API y Rutas

### Sistema de Routing

El sistema usa routing limpio basado en URL:

```
http://tu-dominio/controlador/metodo/parametros
```

### Ejemplos de Rutas

```
/auth/login              → AuthController::login()
/dashboard               → DashboardController::index()
/patients                → PatientsController::index()
/patients/view/123       → PatientsController::view(123)
/appointments/create     → AppointmentsController::create()
```

### Crear un Nuevo Controlador

```php
<?php
class MiController extends Controller {
    public function __construct() {
        $this->requireAuth(); // Requiere autenticación
    }

    public function index() {
        $data = ['title' => 'Mi Página'];
        $this->view('mi_vista/index', $data);
    }
}
```

### Crear un Nuevo Modelo

```php
<?php
class MiModelo extends Model {
    protected $table = 'mi_tabla';
    protected $primaryKey = 'id';

    public function miMetodo() {
        return $this->all();
    }
}
```

---

## 🚀 Desarrollo

### Agregar una Nueva Funcionalidad

1. **Crear Modelo** en `app/models/`
2. **Crear Controlador** en `app/controllers/`
3. **Crear Vista** en `app/views/`
4. **Actualizar Base de Datos** si es necesario

### Ejemplo: Agregar Módulo de Inventario

```bash
# 1. Crear Modelo
touch app/models/Product.php

# 2. Crear Controlador
touch app/controllers/ProductsController.php

# 3. Crear Vistas
mkdir app/views/products
touch app/views/products/index.php
touch app/views/products/create.php

# 4. Actualizar Base de Datos
mysql -u root -p innovadent < database/migrations/add_products.sql
```

---

## 📚 Documentación Adicional

- [📘 Diseño del Sistema](SYSTEM_DESIGN.md) - Especificaciones completas
- [📗 Schema de Base de Datos](DATABASE_SCHEMA.md) - Modelo de datos
- [📙 Guía de Instalación](INSTALL.md) - Instalación detallada
- [📕 Diagramas ERD](DATABASE_ERD.md) - Diagramas visuales

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| **Backend** | PHP 7.4+ (Puro, sin frameworks) |
| **Patrón** | MVC (Model-View-Controller) |
| **Base de Datos** | MySQL 8.0+ |
| **Frontend** | Bootstrap 5.3, jQuery 3.7 |
| **Servidor Web** | Apache 2.4+ con mod_rewrite |
| **Iconos** | Font Awesome 6.4 |

---

## 🔄 Próximas Mejoras

### Versión 1.1 (Planificado)

- [ ] Módulo de Tratamientos completo
- [ ] Facturación electrónica (CFDI/FE)
- [ ] Odontograma 2D interactivo
- [ ] Reportes PDF con gráficos
- [ ] Búsqueda avanzada
- [ ] Exportación de datos (Excel/CSV)

### Versión 1.2 (Planificado)

- [ ] API REST
- [ ] Notificaciones en tiempo real
- [ ] Integración WhatsApp
- [ ] Recordatorios automáticos
- [ ] Multi-idioma
- [ ] Modo oscuro

### Versión 2.0 (Futuro)

- [ ] Odontograma 3D
- [ ] Inteligencia Artificial
- [ ] App móvil
- [ ] Videoconsulta
- [ ] Blockchain para registros

---

## 🤝 Contribuir

¡Las contribuciones son bienvenidas!

### Cómo Contribuir

1. Fork el proyecto
2. Crear una rama (`git checkout -b feature/NuevaFuncionalidad`)
3. Commit cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/NuevaFuncionalidad`)
5. Abrir Pull Request

### Guía de Estilo

- PSR-12 para código PHP
- Comentarios en español
- Nombres descriptivos en variables
- Documentar funciones importantes

---

## 🐛 Reportar Bugs

Si encuentras un bug, por favor:

1. Verificar que no esté ya reportado
2. Crear un issue en GitHub con:
   - Descripción del problema
   - Pasos para reproducir
   - Comportamiento esperado
   - Capturas de pantalla (si aplica)
   - Versión de PHP y MySQL

---

## 📞 Soporte y Contacto

- **Email**: soporte@innovadent.com
- **Website**: www.innovadent.com
- **Documentación**: docs.innovadent.com
- **GitHub**: github.com/innovadent

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

```
MIT License

Copyright (c) 2025 INNOVADENT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software")...
```

---

## 🙏 Agradecimientos

- Comunidad PHP
- Bootstrap Team
- Font Awesome
- Todos los contribuidores

---

## ⭐ Changelog

### Version 1.0.0 (2025-01-15)

#### Agregado
- ✅ Sistema MVC completo
- ✅ Autenticación de usuarios
- ✅ Gestión de pacientes
- ✅ Agenda de citas
- ✅ Dashboard interactivo
- ✅ Sistema de roles
- ✅ Base de datos optimizada
- ✅ Interfaz responsive

#### Tecnologías
- PHP 7.4+ puro
- MySQL 8.0
- Bootstrap 5.3
- Font Awesome 6.4

---

<div align="center">

**INNOVADENT** - *Innovando el futuro de la odontología digital*

Desarrollado con ❤️ para clínicas dentales modernas

© 2025 INNOVADENT. Todos los derechos reservados.

[⬆️ Volver arriba](#innovadent-php-mvc-)

</div>
