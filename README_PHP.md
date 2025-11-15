# INNOVADENT PHP MVC 🦷

## Sistema Integral de Gestión para Clínicas Dentales

![Version](https://img.shields.io/badge/version-2.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql)
![License](https://img.shields.io/badge/license-MIT-green.svg)

**INNOVADENT** es un sistema completo de gestión clínica dental desarrollado en PHP puro utilizando el patrón MVC (Modelo-Vista-Controlador). Diseñado para optimizar todos los procesos administrativos, clínicos y financieros de clínicas dentales modernas.

---

## 🚀 Características Principales

### ✅ Implementado en esta Versión

#### Funcionalidades Core
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

#### Características Avanzadas ⭐ NUEVO
- **✓ API REST Completa**: Autenticación con Bearer Token, endpoints para pacientes, citas y autenticación
- **✓ Portal del Paciente**: Acceso autónomo para pacientes, agendamiento de citas, historial
- **✓ Sistema de Reportes**: Reportes avanzados con gráficos, exportación a CSV
- **✓ Módulo de Laboratorio**: Gestión de órdenes a laboratorios dentales
- **✓ Odontograma 2D Interactivo**: Canvas HTML5 con 32 dientes, superficies dentales
- **✓ Odontograma 3D**: Visualización 3D con Three.js, rotación orbital
- **✓ WhatsApp API**: Recordatorios automáticos, confirmaciones, campañas
- **✓ Sistema de Notificaciones**: Recordatorios automatizados, cumpleaños, pacientes inactivos
- **✓ Exportación a PDF**: Presupuestos, recibos de pago, reportes

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

7. **API REST** ✅
   - Autenticación con Bearer Token
   - Endpoints para pacientes, citas, autenticación
   - Documentación completa
   - CORS habilitado

8. **Portal del Paciente** ✅
   - Autenticación con número de paciente + fecha de nacimiento
   - Dashboard con estadísticas personales
   - Visualización de citas programadas e historial
   - Agendamiento autónomo de citas
   - Acceso a documentos y perfil

9. **Sistema de Reportes** ✅
   - Reportes de citas por período
   - Estadísticas diarias/mensuales
   - Exportación a CSV
   - Gráficos interactivos (AJAX)

10. **Módulo de Laboratorio** ✅
    - Gestión de órdenes a laboratorios
    - Tracking de estados (solicitado, en proceso, listo, entregado)
    - Generación automática de números de orden
    - Estadísticas de laboratorio

11. **Odontograma Interactivo** ✅
    - **2D**: Canvas HTML5, 32 dientes, 5 superficies por diente
    - **3D**: Three.js con WebGL, rotación orbital, selección interactiva
    - Marcadores de condiciones (sano, caries, restauración, corona, etc.)
    - Guardado en base de datos

12. **Notificaciones y WhatsApp** ✅
    - WhatsApp Business API via Twilio
    - Recordatorios automáticos de citas (día anterior)
    - Felicitaciones de cumpleaños
    - Seguimiento a pacientes inactivos
    - Campañas promocionales masivas
    - Sistema de notificaciones in-app

13. **Exportación de Documentos** ✅
    - Generación de PDFs (presupuestos, recibos, reportes)
    - Soporte para FPDF o fallback básico
    - Headers personalizados con logo de clínica
    - Formatos profesionales

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
│   │   ├── Router.php       # Sistema de rutas
│   │   └── Api.php          # Clase base para API REST ⭐
│   ├── controllers/         # Controladores Web
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── PatientsController.php
│   │   ├── AppointmentsController.php
│   │   ├── PortalController.php          # Portal del Paciente ⭐
│   │   ├── ReportsController.php         # Sistema de Reportes ⭐
│   │   └── LaboratoryController.php      # Laboratorio Dental ⭐
│   ├── controllers/api/     # Controladores API REST ⭐
│   │   ├── AuthApiController.php
│   │   ├── PatientsApiController.php
│   │   └── AppointmentsApiController.php
│   ├── models/              # Modelos
│   │   ├── User.php
│   │   ├── Patient.php
│   │   ├── Appointment.php
│   │   └── Laboratory.php               # Modelo de Laboratorio ⭐
│   ├── helpers/             # Clases Helper ⭐
│   │   ├── WhatsAppHelper.php           # Integración WhatsApp
│   │   ├── NotificationHelper.php       # Sistema de notificaciones
│   │   └── PdfHelper.php                # Generación de PDFs
│   └── views/               # Vistas
│       ├── layouts/
│       ├── auth/
│       ├── dashboard/
│       ├── patients/
│       ├── appointments/
│       ├── portal/          # Vistas del Portal ⭐
│       ├── reports/         # Vistas de Reportes ⭐
│       └── laboratory/      # Vistas de Laboratorio ⭐
├── public/                  # Archivos públicos
│   ├── css/
│   ├── js/
│   │   └── odontograma/     # JavaScript del Odontograma ⭐
│   │       ├── odontograma-2d.js        # Canvas 2D
│   │       └── odontograma-3d.js        # Three.js 3D
│   ├── images/
│   ├── uploads/
│   ├── index.php           # Punto de entrada web
│   ├── api.php             # Punto de entrada API ⭐
│   └── .htaccess
├── database/
│   ├── schema.sql          # Schema MySQL completo
│   ├── migrations/
│   └── seeds/
├── storage/
│   ├── logs/
│   ├── cache/
│   └── sessions/
├── API_DOCUMENTATION.md    # Documentación completa de API ⭐
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

- **Tabler.io v1.0.0-beta19**: Framework de administración moderno basado en Bootstrap 5
- **Tabler Icons v2.44.0**: Iconografía SVG moderna (2000+ iconos)
- **Bootstrap 5**: Framework CSS base
- **jQuery 3.7**: Manipulación DOM
- **Three.js**: Renderizado 3D para odontograma
- **Canvas API**: Odontograma 2D interactivo
- **UI Avatars API**: Generación dinámica de avatars

### Diseño Moderno con Tabler.io

INNOVADENT utiliza **Tabler.io**, un framework de administración profesional que proporciona:

- **Diseño Limpio**: Interfaz minimalista y moderna
- **Componentes UI**: Cards, badges, alerts, modals prediseñados
- **Navegación Intuitiva**: Sidebar vertical con iconos Tabler
- **Responsive**: Adaptable a todos los dispositivos
- **Accesibilidad**: Componentes accesibles por defecto
- **Temas**: Soporte para tema claro/oscuro

#### Características Visuales

##### Login
- Diseño centrado con gradiente de fondo
- Card flotante con sombra
- Input icons integrados
- Mensajes de error elegantes
- Diseño responsive

##### Dashboard Principal
- Stats cards con hover effects
- Tabla mejorada para citas del día
- Avatars dinámicos para usuarios
- Badges con outline para estados
- Empty states con iconos y acciones
- Progress bars segmentados

##### Portal del Paciente
- Diseño distintivo con gradiente púrpura
- Navbar superior con dropdown de usuario
- Cards de estadísticas personalizadas
- Lista de citas con bordes coloridos
- Acciones rápidas en grid

##### Gestión de Pacientes
- Tabla striped con avatars
- Búsqueda en tiempo real
- Dropdown menu con múltiples acciones
- Paginación mejorada con iconos
- Empty state para lista vacía
- Botones de importación

### Paleta de Colores

- **Primary**: #0066CC (Azul INNOVADENT)
- **Secondary**: #00CC66 (Verde INNOVADENT)
- **Portal**: #667eea (Púrpura Portal Pacientes)
- **Success**: #2fb344
- **Warning**: #f76707
- **Danger**: #d63939
- **Info**: #4299e1

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
| **Frontend** | Tabler.io 1.0.0, Bootstrap 5, jQuery 3.7 |
| **UI Framework** | Tabler.io (Dashboard Admin Template) |
| **Iconografía** | Tabler Icons 2.44.0 (2000+ iconos SVG) |
| **3D Rendering** | Three.js (Odontograma 3D) |
| **Servidor Web** | Apache 2.4+ con mod_rewrite |

---

## 🔄 Próximas Mejoras

### Versión 2.1 (Planificado)

- [ ] Módulo de Tratamientos completo con plan de tratamiento
- [ ] Facturación electrónica (CFDI México / Factura Electrónica)
- [ ] Búsqueda avanzada multi-criterio
- [ ] Importación/Exportación a Excel
- [ ] Multi-idioma (inglés, portugués)
- [ ] Modo oscuro
- [ ] Backup automático en la nube

### Versión 3.0 (Futuro)

- [ ] Inteligencia Artificial para diagnóstico asistido
- [ ] Predicción de ausentismo con ML
- [ ] App móvil nativa (iOS/Android)
- [ ] Videoconsulta integrada
- [ ] Firma digital para consentimientos
- [ ] Blockchain para registros médicos
- [ ] Integración con escáneres intraorales
- [ ] Radiografías digitales integradas

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

### Version 2.0.0 (2025-01-15) - MAJOR UPDATE

#### Agregado - Características Avanzadas 🚀
- ✅ **API REST Completa**: Bearer Token auth, endpoints documentados
- ✅ **Portal del Paciente**: Autenticación, dashboard, agendamiento autónomo
- ✅ **Sistema de Reportes**: Reportes avanzados con exportación CSV
- ✅ **Módulo de Laboratorio**: Gestión completa de órdenes dentales
- ✅ **Odontograma 2D**: Canvas HTML5 interactivo, 32 dientes
- ✅ **Odontograma 3D**: Three.js con WebGL, rotación orbital
- ✅ **WhatsApp API**: Twilio integration, recordatorios automáticos
- ✅ **Sistema de Notificaciones**: Cron jobs, cumpleaños, seguimiento
- ✅ **Exportación PDF**: FPDF integration, presupuestos, recibos
- ✅ **Tabler.io UI**: Interfaz modernizada con framework profesional

#### Tecnologías Nuevas
- **Tabler.io v1.0.0-beta19**: Framework UI moderno
- **Tabler Icons v2.44.0**: Iconografía SVG profesional
- **Three.js**: Visualización 3D para odontograma
- **Canvas API**: Odontograma 2D interactivo
- **Twilio WhatsApp Business API**: Mensajería automatizada
- **FPDF**: Generación de documentos PDF
- **AJAX**: Gráficos dinámicos y búsqueda en tiempo real
- **UI Avatars API**: Generación dinámica de avatars

### Version 1.0.0 (2025-01-10)

#### Agregado - Core System
- ✅ Sistema MVC completo
- ✅ Autenticación de usuarios
- ✅ Gestión de pacientes
- ✅ Agenda de citas
- ✅ Dashboard interactivo
- ✅ Sistema de roles
- ✅ Base de datos optimizada (76 tablas)
- ✅ Interfaz responsive

#### Tecnologías Base
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
