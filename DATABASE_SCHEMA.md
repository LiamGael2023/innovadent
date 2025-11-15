# INNOVADENT - Diseño de Base de Datos

## Tabla de Contenidos
1. [Diagrama de Relaciones (ERD)](#diagrama-de-relaciones-erd)
2. [Catálogo de Tablas](#catálogo-de-tablas)
3. [Definición Detallada de Tablas](#definición-detallada-de-tablas)
4. [Índices y Optimizaciones](#índices-y-optimizaciones)

---

## DIAGRAMA DE RELACIONES (ERD)

### Módulos y sus Tablas Principales

```
📊 MÓDULOS DEL SISTEMA
│
├── 🏢 CONFIGURACIÓN Y MULTIEMPRESA
│   ├── clinics (clínicas/sucursales)
│   ├── users (usuarios del sistema)
│   ├── roles (roles)
│   ├── permissions (permisos)
│   ├── role_permissions (roles-permisos)
│   └── user_roles (usuarios-roles)
│
├── 👥 PACIENTES
│   ├── patients (pacientes)
│   ├── patient_contacts (contactos de emergencia)
│   ├── patient_insurances (seguros médicos)
│   ├── patient_documents (documentos)
│   └── patient_photos (fotos clínicas)
│
├── 📅 AGENDA Y CITAS
│   ├── appointments (citas)
│   ├── appointment_types (tipos de cita)
│   ├── appointment_reminders (recordatorios enviados)
│   ├── working_hours (horarios de trabajo)
│   └── waiting_room (sala de espera)
│
├── 🦷 HISTORIA CLÍNICA
│   ├── medical_histories (historia clínica general)
│   ├── clinical_notes (notas clínicas por cita)
│   ├── vital_signs (signos vitales)
│   ├── allergies (alergias)
│   ├── medications (medicamentos actuales)
│   └── informed_consents (consentimientos informados)
│
├── 🦷 ODONTOGRAMA Y PERIODONTOGRAMA
│   ├── odontograms (odontogramas)
│   ├── odontogram_teeth (dientes del odontograma)
│   ├── odontogram_conditions (condiciones/hallazgos)
│   ├── periodontograms (periodontogramas)
│   └── periodontal_measurements (mediciones periodontales)
│
├── 🦴 ORTODONCIA
│   ├── orthodontic_cases (casos ortodónticos)
│   ├── orthodontic_photos (fotos de seguimiento)
│   ├── orthodontic_activations (activaciones)
│   ├── cephalometric_analyses (análisis cefalométricos)
│   └── orthodontic_appliances (aparatología)
│
├── 💊 TRATAMIENTOS Y PRESUPUESTOS
│   ├── treatment_categories (categorías de tratamientos)
│   ├── treatments (catálogo de tratamientos)
│   ├── treatment_materials (materiales por tratamiento)
│   ├── quotes (presupuestos)
│   ├── quote_items (ítems del presupuesto)
│   ├── treatment_plans (planes de tratamiento)
│   └── treatment_plan_items (ítems del plan)
│
├── 💰 FACTURACIÓN Y PAGOS
│   ├── invoices (facturas)
│   ├── invoice_items (ítems de factura)
│   ├── payments (pagos)
│   ├── payment_methods (formas de pago)
│   ├── payment_plans (planes de financiamiento)
│   └── payment_plan_installments (cuotas)
│
├── 📊 CONTROL FINANCIERO
│   ├── income_categories (categorías de ingresos)
│   ├── incomes (ingresos)
│   ├── expense_categories (categorías de egresos)
│   ├── expenses (egresos)
│   ├── cash_registers (cajas)
│   ├── cash_register_movements (movimientos de caja)
│   └── bank_reconciliations (conciliaciones bancarias)
│
├── 📦 INVENTARIO Y COMPRAS
│   ├── product_categories (categorías de productos)
│   ├── products (productos)
│   ├── warehouses (almacenes)
│   ├── inventory_movements (movimientos de inventario)
│   ├── suppliers (proveedores)
│   ├── purchase_orders (órdenes de compra)
│   └── purchase_order_items (ítems de orden de compra)
│
├── 🔬 LABORATORIO DENTAL
│   ├── dental_labs (laboratorios externos)
│   ├── prosthetic_types (tipos de prótesis)
│   ├── lab_orders (órdenes de laboratorio)
│   ├── lab_order_photos (fotos de trabajos)
│   └── lab_evaluations (evaluaciones de calidad)
│
└── 📈 AUDITORÍA Y LOGS
    ├── audit_logs (registro de auditoría)
    ├── system_logs (logs del sistema)
    └── notifications (notificaciones)
```

---

## CATÁLOGO DE TABLAS

### Total: 77 Tablas

| # | Tabla | Módulo | Descripción |
|---|-------|--------|-------------|
| 1 | clinics | Configuración | Clínicas/Sucursales |
| 2 | users | Configuración | Usuarios del sistema |
| 3 | roles | Configuración | Roles |
| 4 | permissions | Configuración | Permisos |
| 5 | role_permissions | Configuración | Relación roles-permisos |
| 6 | user_roles | Configuración | Relación usuarios-roles |
| 7 | patients | Pacientes | Información de pacientes |
| 8 | patient_contacts | Pacientes | Contactos de emergencia |
| 9 | patient_insurances | Pacientes | Seguros médicos |
| 10 | patient_documents | Pacientes | Documentos adjuntos |
| 11 | patient_photos | Pacientes | Fotos clínicas |
| 12 | appointments | Citas | Citas agendadas |
| 13 | appointment_types | Citas | Tipos de cita |
| 14 | appointment_reminders | Citas | Recordatorios enviados |
| 15 | working_hours | Citas | Horarios de trabajo |
| 16 | waiting_room | Citas | Sala de espera digital |
| 17 | medical_histories | Historia Clínica | Historia clínica general |
| 18 | clinical_notes | Historia Clínica | Notas clínicas |
| 19 | vital_signs | Historia Clínica | Signos vitales |
| 20 | allergies | Historia Clínica | Alergias |
| 21 | medications | Historia Clínica | Medicamentos actuales |
| 22 | informed_consents | Historia Clínica | Consentimientos |
| 23 | odontograms | Odontograma | Odontogramas |
| 24 | odontogram_teeth | Odontograma | Dientes |
| 25 | odontogram_conditions | Odontograma | Condiciones dentales |
| 26 | periodontograms | Periodontograma | Periodontogramas |
| 27 | periodontal_measurements | Periodontograma | Mediciones |
| 28 | orthodontic_cases | Ortodoncia | Casos ortodónticos |
| 29 | orthodontic_photos | Ortodoncia | Fotos de seguimiento |
| 30 | orthodontic_activations | Ortodoncia | Activaciones |
| 31 | cephalometric_analyses | Ortodoncia | Análisis cefalométrico |
| 32 | orthodontic_appliances | Ortodoncia | Aparatología |
| 33 | treatment_categories | Tratamientos | Categorías |
| 34 | treatments | Tratamientos | Catálogo de tratamientos |
| 35 | treatment_materials | Tratamientos | Materiales por tratamiento |
| 36 | quotes | Presupuestos | Presupuestos |
| 37 | quote_items | Presupuestos | Ítems del presupuesto |
| 38 | treatment_plans | Planes de tratamiento | Planes |
| 39 | treatment_plan_items | Planes de tratamiento | Ítems del plan |
| 40 | invoices | Facturación | Facturas |
| 41 | invoice_items | Facturación | Ítems de factura |
| 42 | payments | Pagos | Pagos recibidos |
| 43 | payment_methods | Pagos | Formas de pago |
| 44 | payment_plans | Financiamiento | Planes de pago |
| 45 | payment_plan_installments | Financiamiento | Cuotas |
| 46 | income_categories | Finanzas | Categorías de ingresos |
| 47 | incomes | Finanzas | Ingresos |
| 48 | expense_categories | Finanzas | Categorías de egresos |
| 49 | expenses | Finanzas | Egresos |
| 50 | cash_registers | Caja | Cajas registradoras |
| 51 | cash_register_movements | Caja | Movimientos de caja |
| 52 | product_categories | Inventario | Categorías de productos |
| 53 | products | Inventario | Catálogo de productos |
| 54 | warehouses | Inventario | Almacenes |
| 55 | inventory_movements | Inventario | Movimientos |
| 56 | suppliers | Compras | Proveedores |
| 57 | purchase_orders | Compras | Órdenes de compra |
| 58 | purchase_order_items | Compras | Ítems de OC |
| 59 | dental_labs | Laboratorio | Laboratorios externos |
| 60 | prosthetic_types | Laboratorio | Tipos de prótesis |
| 61 | lab_orders | Laboratorio | Órdenes de laboratorio |
| 62 | lab_order_photos | Laboratorio | Fotos de trabajos |
| 63 | lab_evaluations | Laboratorio | Evaluaciones |
| 64 | audit_logs | Auditoría | Logs de auditoría |
| 65 | system_logs | Sistema | Logs del sistema |
| 66 | notifications | Comunicación | Notificaciones |
| 67 | whatsapp_messages | Comunicación | Mensajes WhatsApp |
| 68 | email_messages | Comunicación | Emails enviados |
| 69 | sms_messages | Comunicación | SMS enviados |
| 70 | catalogs | Configuración | Catálogos generales |
| 71 | catalog_items | Configuración | Ítems de catálogos |
| 72 | appointment_cancellation_reasons | Catálogos | Motivos de cancelación |
| 73 | patient_sources | Catálogos | Origen de pacientes |
| 74 | specialties | Catálogos | Especialidades |
| 75 | countries | Catálogos | Países |
| 76 | states | Catálogos | Estados/Provincias |
| 77 | cities | Catálogos | Ciudades |

---

## DEFINICIÓN DETALLADA DE TABLAS

### 🏢 MÓDULO: CONFIGURACIÓN Y MULTIEMPRESA

#### 1. clinics (Clínicas/Sucursales)
```sql
CREATE TABLE clinics (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(20) UNIQUE NOT NULL COMMENT 'Código único de la clínica',
    name VARCHAR(255) NOT NULL COMMENT 'Nombre comercial',
    legal_name VARCHAR(255) COMMENT 'Razón social',
    tax_id VARCHAR(50) COMMENT 'RFC/NIT/RUC/Tax ID',
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    city_id BIGINT COMMENT 'FK a cities',
    postal_code VARCHAR(10),
    logo_url VARCHAR(500) COMMENT 'URL del logo',
    primary_color VARCHAR(7) DEFAULT '#0066CC' COMMENT 'Color corporativo',
    secondary_color VARCHAR(7) DEFAULT '#00CC66',
    timezone VARCHAR(50) DEFAULT 'America/Mexico_City',
    currency VARCHAR(3) DEFAULT 'MXN',
    language VARCHAR(5) DEFAULT 'es',
    is_active BOOLEAN DEFAULT TRUE,
    is_main BOOLEAN DEFAULT FALSE COMMENT 'Clínica principal',
    settings JSON COMMENT 'Configuraciones específicas de la clínica',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    INDEX idx_code (code),
    INDEX idx_is_active (is_active),
    FOREIGN KEY (city_id) REFERENCES cities(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 2. users (Usuarios)
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL COMMENT 'FK a clinics',
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    photo_url VARCHAR(500),
    employee_number VARCHAR(50) COMMENT 'Número de empleado',
    specialty_id BIGINT COMMENT 'FK a specialties (para doctores)',
    professional_license VARCHAR(100) COMMENT 'Cédula profesional',
    is_doctor BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    two_factor_enabled BOOLEAN DEFAULT FALSE,
    two_factor_secret VARCHAR(255),
    preferences JSON COMMENT 'Preferencias del usuario',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    INDEX idx_clinic (clinic_id),
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_is_doctor (is_doctor),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (specialty_id) REFERENCES specialties(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3. roles (Roles)
```sql
CREATE TABLE roles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    is_system BOOLEAN DEFAULT FALSE COMMENT 'Rol de sistema (no editable)',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 4. permissions (Permisos)
```sql
CREATE TABLE permissions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    module VARCHAR(100) NOT NULL COMMENT 'Módulo del sistema',
    action VARCHAR(50) NOT NULL COMMENT 'create, read, update, delete, etc.',
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_module (module),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 5. role_permissions (Roles-Permisos)
```sql
CREATE TABLE role_permissions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    role_id BIGINT NOT NULL,
    permission_id BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_role_permission (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 6. user_roles (Usuarios-Roles)
```sql
CREATE TABLE user_roles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    clinic_id BIGINT COMMENT 'Rol específico por clínica (null = todas)',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_user_role_clinic (user_id, role_id, clinic_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 👥 MÓDULO: PACIENTES

#### 7. patients (Pacientes)
```sql
CREATE TABLE patients (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_number VARCHAR(50) UNIQUE NOT NULL COMMENT 'Número de expediente',
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    second_last_name VARCHAR(100),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other') NOT NULL,
    blood_type VARCHAR(5) COMMENT 'A+, O-, etc.',
    email VARCHAR(255),
    phone VARCHAR(20),
    mobile VARCHAR(20),
    address TEXT,
    city_id BIGINT,
    postal_code VARCHAR(10),
    occupation VARCHAR(100),
    marital_status ENUM('single', 'married', 'divorced', 'widowed', 'other'),
    referred_by VARCHAR(255) COMMENT 'Referido por',
    patient_source_id BIGINT COMMENT 'FK a patient_sources',
    photo_url VARCHAR(500),
    notes TEXT COMMENT 'Notas generales del paciente',
    is_active BOOLEAN DEFAULT TRUE,
    last_visit_date DATE,
    next_visit_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient_number (patient_number),
    INDEX idx_full_name (first_name, last_name),
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_is_active (is_active),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (city_id) REFERENCES cities(id),
    FOREIGN KEY (patient_source_id) REFERENCES patient_sources(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 8. patient_contacts (Contactos de Emergencia)
```sql
CREATE TABLE patient_contacts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    relationship VARCHAR(100) COMMENT 'Padre, madre, esposo/a, hijo/a, etc.',
    phone VARCHAR(20),
    mobile VARCHAR(20),
    email VARCHAR(255),
    is_emergency_contact BOOLEAN DEFAULT FALSE,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 9. patient_insurances (Seguros Médicos)
```sql
CREATE TABLE patient_insurances (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    insurance_company VARCHAR(255) NOT NULL,
    policy_number VARCHAR(100),
    group_number VARCHAR(100),
    start_date DATE,
    end_date DATE,
    coverage_details TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 10. patient_documents (Documentos)
```sql
CREATE TABLE patient_documents (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    document_type VARCHAR(100) COMMENT 'ID, consentimiento, contrato, etc.',
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(50) COMMENT 'pdf, jpg, png, etc.',
    file_size BIGINT COMMENT 'Tamaño en bytes',
    description TEXT,
    uploaded_by BIGINT COMMENT 'FK a users',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_document_type (document_type),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 11. patient_photos (Fotos Clínicas)
```sql
CREATE TABLE patient_photos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    appointment_id BIGINT COMMENT 'FK a appointments (opcional)',
    photo_type ENUM('extraoral', 'intraoral', 'radiograph', 'scan', 'other') NOT NULL,
    photo_category VARCHAR(100) COMMENT 'Frontal, lateral, oclusal, etc.',
    file_path VARCHAR(500) NOT NULL,
    thumbnail_path VARCHAR(500),
    description TEXT,
    taken_at TIMESTAMP,
    taken_by BIGINT COMMENT 'FK a users',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_appointment (appointment_id),
    INDEX idx_photo_type (photo_type),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (taken_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 📅 MÓDULO: AGENDA Y CITAS

#### 12. appointments (Citas)
```sql
CREATE TABLE appointments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL COMMENT 'FK a users',
    appointment_type_id BIGINT,
    appointment_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    duration_minutes INT NOT NULL DEFAULT 30,
    status ENUM('scheduled', 'confirmed', 'waiting', 'in_progress', 'completed', 'cancelled', 'no_show', 'rescheduled') DEFAULT 'scheduled',
    chair_number VARCHAR(20) COMMENT 'Número de sillón',
    reason TEXT COMMENT 'Motivo de la cita',
    notes TEXT COMMENT 'Notas de la cita',
    cancellation_reason_id BIGINT COMMENT 'FK a appointment_cancellation_reasons',
    cancellation_notes TEXT,
    cancelled_by BIGINT COMMENT 'FK a users',
    cancelled_at TIMESTAMP NULL,
    confirmed_at TIMESTAMP NULL,
    arrived_at TIMESTAMP NULL COMMENT 'Hora de llegada del paciente',
    started_at TIMESTAMP NULL COMMENT 'Hora de inicio de atención',
    completed_at TIMESTAMP NULL,
    created_by BIGINT COMMENT 'FK a users',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id),
    INDEX idx_appointment_date (appointment_date),
    INDEX idx_status (status),
    INDEX idx_datetime (appointment_date, start_time),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (appointment_type_id) REFERENCES appointment_types(id),
    FOREIGN KEY (cancellation_reason_id) REFERENCES appointment_cancellation_reasons(id),
    FOREIGN KEY (cancelled_by) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 13. appointment_types (Tipos de Cita)
```sql
CREATE TABLE appointment_types (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(7) DEFAULT '#0066CC' COMMENT 'Color hex para calendario',
    default_duration_minutes INT DEFAULT 30,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 14. appointment_reminders (Recordatorios)
```sql
CREATE TABLE appointment_reminders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    appointment_id BIGINT NOT NULL,
    reminder_type ENUM('whatsapp', 'sms', 'email', 'call') NOT NULL,
    recipient VARCHAR(255) NOT NULL COMMENT 'Número o email',
    message TEXT,
    scheduled_at TIMESTAMP NOT NULL,
    sent_at TIMESTAMP NULL,
    status ENUM('pending', 'sent', 'delivered', 'failed', 'read') DEFAULT 'pending',
    error_message TEXT,
    response TEXT COMMENT 'Respuesta del paciente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_appointment (appointment_id),
    INDEX idx_status (status),
    INDEX idx_scheduled_at (scheduled_at),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 15. working_hours (Horarios de Trabajo)
```sql
CREATE TABLE working_hours (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    doctor_id BIGINT COMMENT 'FK a users (null = horario general de clínica)',
    day_of_week TINYINT NOT NULL COMMENT '0=Domingo, 1=Lunes, ..., 6=Sábado',
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    effective_from DATE COMMENT 'Fecha de inicio de vigencia',
    effective_to DATE COMMENT 'Fecha fin de vigencia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_doctor (doctor_id),
    INDEX idx_day (day_of_week),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 16. waiting_room (Sala de Espera)
```sql
CREATE TABLE waiting_room (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    appointment_id BIGINT NOT NULL,
    queue_number INT COMMENT 'Número de turno',
    checked_in_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estimated_wait_minutes INT,
    called_at TIMESTAMP NULL,
    status ENUM('waiting', 'called', 'in_progress', 'completed') DEFAULT 'waiting',

    INDEX idx_appointment (appointment_id),
    INDEX idx_status (status),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 🦷 MÓDULO: HISTORIA CLÍNICA

#### 17. medical_histories (Historia Clínica General)
```sql
CREATE TABLE medical_histories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL UNIQUE,
    has_systemic_diseases BOOLEAN DEFAULT FALSE,
    systemic_diseases TEXT COMMENT 'Diabetes, hipertensión, etc.',
    has_heart_disease BOOLEAN DEFAULT FALSE,
    heart_disease_details TEXT,
    has_respiratory_disease BOOLEAN DEFAULT FALSE,
    respiratory_disease_details TEXT,
    has_kidney_disease BOOLEAN DEFAULT FALSE,
    kidney_disease_details TEXT,
    has_liver_disease BOOLEAN DEFAULT FALSE,
    liver_disease_details TEXT,
    has_bleeding_disorders BOOLEAN DEFAULT FALSE,
    bleeding_disorders_details TEXT,
    is_pregnant BOOLEAN DEFAULT FALSE,
    pregnancy_weeks INT,
    is_breastfeeding BOOLEAN DEFAULT FALSE,
    is_smoker BOOLEAN DEFAULT FALSE,
    smoking_frequency VARCHAR(100),
    consumes_alcohol BOOLEAN DEFAULT FALSE,
    alcohol_frequency VARCHAR(100),
    uses_drugs BOOLEAN DEFAULT FALSE,
    drug_details TEXT,
    previous_surgeries TEXT,
    hospitalizations TEXT,
    blood_transfusions TEXT,
    family_medical_history TEXT,
    dental_history TEXT COMMENT 'Historial dental previo',
    dental_hygiene_habits TEXT,
    brushing_frequency VARCHAR(100),
    flossing_frequency VARCHAR(100),
    last_dental_visit DATE,
    reason_for_last_visit TEXT,
    fears_or_anxieties TEXT COMMENT 'Fobias o ansiedades',
    additional_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 18. clinical_notes (Notas Clínicas)
```sql
CREATE TABLE clinical_notes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    appointment_id BIGINT COMMENT 'FK a appointments (opcional)',
    doctor_id BIGINT NOT NULL,
    note_type ENUM('evolution', 'diagnosis', 'treatment', 'observation', 'other') DEFAULT 'evolution',
    subject VARCHAR(255),
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_appointment (appointment_id),
    INDEX idx_doctor (doctor_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 19. vital_signs (Signos Vitales)
```sql
CREATE TABLE vital_signs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    appointment_id BIGINT,
    blood_pressure_systolic INT COMMENT 'mmHg',
    blood_pressure_diastolic INT COMMENT 'mmHg',
    heart_rate INT COMMENT 'bpm',
    temperature DECIMAL(4,1) COMMENT 'Celsius',
    respiratory_rate INT COMMENT 'rpm',
    oxygen_saturation DECIMAL(5,2) COMMENT '%',
    glucose DECIMAL(6,2) COMMENT 'mg/dL',
    weight DECIMAL(6,2) COMMENT 'kg',
    height DECIMAL(5,2) COMMENT 'cm',
    notes TEXT,
    measured_by BIGINT COMMENT 'FK a users',
    measured_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_appointment (appointment_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (measured_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 20. allergies (Alergias)
```sql
CREATE TABLE allergies (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    allergen VARCHAR(255) NOT NULL COMMENT 'Alérgeno',
    allergen_type ENUM('medication', 'food', 'environmental', 'dental_material', 'other') NOT NULL,
    reaction TEXT COMMENT 'Reacción alérgica',
    severity ENUM('mild', 'moderate', 'severe') DEFAULT 'moderate',
    notes TEXT,
    diagnosed_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_allergen_type (allergen_type),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 21. medications (Medicamentos Actuales)
```sql
CREATE TABLE medications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    medication_name VARCHAR(255) NOT NULL,
    dosage VARCHAR(100),
    frequency VARCHAR(100),
    route ENUM('oral', 'topical', 'injection', 'other') DEFAULT 'oral',
    reason TEXT COMMENT 'Motivo de prescripción',
    start_date DATE,
    end_date DATE,
    is_current BOOLEAN DEFAULT TRUE,
    prescribed_by VARCHAR(255) COMMENT 'Médico que prescribió',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_is_current (is_current),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 22. informed_consents (Consentimientos Informados)
```sql
CREATE TABLE informed_consents (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    treatment_id BIGINT COMMENT 'FK a treatments',
    consent_type VARCHAR(100) COMMENT 'Tipo de consentimiento',
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL COMMENT 'Contenido del consentimiento',
    signed_at TIMESTAMP,
    signature_data TEXT COMMENT 'Datos de firma digital (base64)',
    witness_name VARCHAR(255),
    witness_signature_data TEXT,
    doctor_id BIGINT COMMENT 'FK a users',
    document_path VARCHAR(500) COMMENT 'PDF generado',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_treatment (treatment_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (treatment_id) REFERENCES treatments(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 🦷 MÓDULO: ODONTOGRAMA Y PERIODONTOGRAMA

#### 23. odontograms (Odontogramas)
```sql
CREATE TABLE odontograms (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    appointment_id BIGINT,
    doctor_id BIGINT NOT NULL,
    nomenclature ENUM('universal', 'palmer', 'fdi') DEFAULT 'universal',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_appointment (appointment_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 24. odontogram_teeth (Dientes del Odontograma)
```sql
CREATE TABLE odontogram_teeth (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    odontogram_id BIGINT NOT NULL,
    tooth_number VARCHAR(10) NOT NULL COMMENT 'Nomenclatura del diente',
    tooth_type ENUM('permanent', 'deciduous') DEFAULT 'permanent',
    is_present BOOLEAN DEFAULT TRUE,
    absence_reason ENUM('extracted', 'congenital', 'other') COMMENT 'Si no está presente',
    mobility ENUM('0', '1', '2', '3') COMMENT 'Grado de movilidad',
    notes TEXT,

    INDEX idx_odontogram (odontogram_id),
    INDEX idx_tooth_number (tooth_number),
    FOREIGN KEY (odontogram_id) REFERENCES odontograms(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 25. odontogram_conditions (Condiciones/Hallazgos)
```sql
CREATE TABLE odontogram_conditions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    odontogram_tooth_id BIGINT NOT NULL,
    condition_type ENUM('caries', 'restoration', 'crown', 'bridge', 'implant', 'endodontics', 'extraction', 'fracture', 'other') NOT NULL,
    surface VARCHAR(50) COMMENT 'Mesial, distal, oclusal, vestibular, lingual',
    material VARCHAR(100) COMMENT 'Amalgama, resina, porcelana, etc.',
    status ENUM('planned', 'in_progress', 'completed') DEFAULT 'completed',
    severity ENUM('mild', 'moderate', 'severe') COMMENT 'Para caries',
    color VARCHAR(7) COMMENT 'Color para visualización',
    notes TEXT,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_tooth (odontogram_tooth_id),
    INDEX idx_condition_type (condition_type),
    INDEX idx_status (status),
    FOREIGN KEY (odontogram_tooth_id) REFERENCES odontogram_teeth(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 26. periodontograms (Periodontogramas)
```sql
CREATE TABLE periodontograms (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    appointment_id BIGINT,
    doctor_id BIGINT NOT NULL,
    oleary_index DECIMAL(5,2) COMMENT 'Índice de O\'Leary',
    ihos_index DECIMAL(5,2) COMMENT 'Índice de higiene oral simplificado',
    diagnosis TEXT COMMENT 'Diagnóstico periodontal',
    treatment_plan TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_appointment (appointment_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 27. periodontal_measurements (Mediciones Periodontales)
```sql
CREATE TABLE periodontal_measurements (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    periodontogram_id BIGINT NOT NULL,
    tooth_number VARCHAR(10) NOT NULL,
    position ENUM('mesial', 'center', 'distal') NOT NULL,
    aspect ENUM('vestibular', 'lingual') NOT NULL,
    probing_depth INT COMMENT 'Profundidad de sondaje en mm',
    gingival_margin INT COMMENT 'Margen gingival en mm',
    clinical_attachment_level INT COMMENT 'Nivel de inserción clínica',
    bleeding_on_probing BOOLEAN DEFAULT FALSE,
    plaque_present BOOLEAN DEFAULT FALSE,
    gingival_recession INT COMMENT 'Recesión gingival en mm',
    furcation ENUM('0', '1', '2', '3') COMMENT 'Grado de furca',

    INDEX idx_periodontogram (periodontogram_id),
    INDEX idx_tooth_number (tooth_number),
    FOREIGN KEY (periodontogram_id) REFERENCES periodontograms(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 🦴 MÓDULO: ORTODONCIA

#### 28. orthodontic_cases (Casos Ortodónticos)
```sql
CREATE TABLE orthodontic_cases (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    case_number VARCHAR(50) UNIQUE,
    start_date DATE NOT NULL,
    estimated_end_date DATE,
    actual_end_date DATE,
    status ENUM('active', 'completed', 'suspended', 'cancelled') DEFAULT 'active',
    treatment_type ENUM('fixed', 'removable', 'invisible', 'interceptive', 'other') NOT NULL,
    chief_complaint TEXT COMMENT 'Motivo de consulta',
    diagnosis TEXT,
    treatment_plan TEXT,
    extraction_plan TEXT COMMENT 'Plan de extracciones',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id),
    INDEX idx_status (status),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 29. orthodontic_photos (Fotos de Seguimiento)
```sql
CREATE TABLE orthodontic_photos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    orthodontic_case_id BIGINT NOT NULL,
    photo_type ENUM('extraoral_frontal', 'extraoral_lateral', 'extraoral_smile', 'intraoral_frontal', 'intraoral_lateral_right', 'intraoral_lateral_left', 'intraoral_occlusal_upper', 'intraoral_occlusal_lower', 'other') NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    thumbnail_path VARCHAR(500),
    description TEXT,
    taken_at DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_case (orthodontic_case_id),
    INDEX idx_photo_type (photo_type),
    INDEX idx_taken_at (taken_at),
    FOREIGN KEY (orthodontic_case_id) REFERENCES orthodontic_cases(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 30. orthodontic_activations (Activaciones)
```sql
CREATE TABLE orthodontic_activations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    orthodontic_case_id BIGINT NOT NULL,
    appointment_id BIGINT,
    activation_date DATE NOT NULL,
    arch ENUM('upper', 'lower', 'both') NOT NULL,
    wire_type VARCHAR(100) COMMENT 'Tipo de arco',
    wire_size VARCHAR(50) COMMENT 'Calibre del arco',
    elastics_configuration TEXT COMMENT 'Configuración de elásticos',
    brackets_placed TEXT COMMENT 'Brackets colocados',
    brackets_removed TEXT COMMENT 'Brackets removidos',
    procedures_performed TEXT COMMENT 'Procedimientos realizados',
    next_appointment_weeks INT DEFAULT 4,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_case (orthodontic_case_id),
    INDEX idx_activation_date (activation_date),
    FOREIGN KEY (orthodontic_case_id) REFERENCES orthodontic_cases(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 31. cephalometric_analyses (Análisis Cefalométricos)
```sql
CREATE TABLE cephalometric_analyses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    orthodontic_case_id BIGINT NOT NULL,
    analysis_date DATE NOT NULL,
    analysis_type VARCHAR(100) COMMENT 'Steiner, Ricketts, McNamara, etc.',
    sna_angle DECIMAL(5,2),
    snb_angle DECIMAL(5,2),
    anb_angle DECIMAL(5,2),
    facial_angle DECIMAL(5,2),
    y_axis DECIMAL(5,2),
    measurements JSON COMMENT 'Otras mediciones cefalométricas',
    interpretation TEXT,
    image_path VARCHAR(500) COMMENT 'Trazado cefalométrico',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_case (orthodontic_case_id),
    FOREIGN KEY (orthodontic_case_id) REFERENCES orthodontic_cases(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 32. orthodontic_appliances (Aparatología)
```sql
CREATE TABLE orthodontic_appliances (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    orthodontic_case_id BIGINT NOT NULL,
    appliance_type ENUM('bracket', 'band', 'expander', 'retainer', 'headgear', 'other') NOT NULL,
    appliance_name VARCHAR(255) NOT NULL,
    installed_date DATE,
    removed_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_case (orthodontic_case_id),
    FOREIGN KEY (orthodontic_case_id) REFERENCES orthodontic_cases(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 💊 MÓDULO: TRATAMIENTOS Y PRESUPUESTOS

#### 33. treatment_categories (Categorías)
```sql
CREATE TABLE treatment_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    parent_id BIGINT COMMENT 'Para categorías jerárquicas',
    name VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    color VARCHAR(7),
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_parent (parent_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (parent_id) REFERENCES treatment_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 34. treatments (Catálogo de Tratamientos)
```sql
CREATE TABLE treatments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    category_id BIGINT,
    code VARCHAR(50) UNIQUE COMMENT 'Código interno',
    name VARCHAR(255) NOT NULL,
    description TEXT,
    default_price DECIMAL(10,2) NOT NULL,
    cost DECIMAL(10,2) COMMENT 'Costo del tratamiento',
    duration_minutes INT DEFAULT 30,
    requires_lab BOOLEAN DEFAULT FALSE COMMENT 'Requiere laboratorio dental',
    is_package BOOLEAN DEFAULT FALSE COMMENT 'Es un paquete de tratamientos',
    image_url VARCHAR(500),
    instructions TEXT COMMENT 'Instrucciones pre/post tratamiento',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_category (category_id),
    INDEX idx_code (code),
    INDEX idx_name (name),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (category_id) REFERENCES treatment_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 35. treatment_materials (Materiales por Tratamiento)
```sql
CREATE TABLE treatment_materials (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    treatment_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL COMMENT 'FK a products',
    quantity DECIMAL(10,2) NOT NULL DEFAULT 1,
    unit VARCHAR(50),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_treatment (treatment_id),
    INDEX idx_product (product_id),
    FOREIGN KEY (treatment_id) REFERENCES treatments(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 36. quotes (Presupuestos)
```sql
CREATE TABLE quotes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    quote_number VARCHAR(50) UNIQUE NOT NULL,
    quote_date DATE NOT NULL,
    valid_until DATE,
    status ENUM('draft', 'pending', 'approved', 'rejected', 'expired', 'converted') DEFAULT 'pending',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    discount_percentage DECIMAL(5,2) DEFAULT 0,
    discount_amount DECIMAL(12,2) DEFAULT 0,
    tax_percentage DECIMAL(5,2) DEFAULT 0,
    tax_amount DECIMAL(12,2) DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    notes TEXT,
    terms_and_conditions TEXT,
    approved_at TIMESTAMP NULL,
    rejected_at TIMESTAMP NULL,
    rejection_reason TEXT,
    created_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id),
    INDEX idx_quote_number (quote_number),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 37. quote_items (Ítems del Presupuesto)
```sql
CREATE TABLE quote_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    quote_id BIGINT NOT NULL,
    treatment_id BIGINT NOT NULL,
    tooth_number VARCHAR(10) COMMENT 'Diente(s) involucrado(s)',
    quantity INT DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    discount_percentage DECIMAL(5,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    subtotal DECIMAL(10,2) NOT NULL,
    notes TEXT,
    sort_order INT DEFAULT 0,

    INDEX idx_quote (quote_id),
    INDEX idx_treatment (treatment_id),
    FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE CASCADE,
    FOREIGN KEY (treatment_id) REFERENCES treatments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 38. treatment_plans (Planes de Tratamiento)
```sql
CREATE TABLE treatment_plans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    quote_id BIGINT COMMENT 'Presupuesto asociado',
    plan_number VARCHAR(50) UNIQUE NOT NULL,
    plan_name VARCHAR(255),
    start_date DATE,
    estimated_end_date DATE,
    actual_end_date DATE,
    status ENUM('active', 'completed', 'suspended', 'cancelled') DEFAULT 'active',
    priority ENUM('urgent', 'high', 'medium', 'low') DEFAULT 'medium',
    total_estimated_cost DECIMAL(12,2),
    total_actual_cost DECIMAL(12,2) DEFAULT 0,
    completion_percentage DECIMAL(5,2) DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (quote_id) REFERENCES quotes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 39. treatment_plan_items (Ítems del Plan)
```sql
CREATE TABLE treatment_plan_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    treatment_plan_id BIGINT NOT NULL,
    treatment_id BIGINT NOT NULL,
    appointment_id BIGINT COMMENT 'Cita donde se realizó',
    tooth_number VARCHAR(10),
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    priority INT DEFAULT 0 COMMENT 'Orden de ejecución',
    scheduled_date DATE,
    completed_date DATE,
    estimated_cost DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_plan (treatment_plan_id),
    INDEX idx_treatment (treatment_id),
    INDEX idx_status (status),
    FOREIGN KEY (treatment_plan_id) REFERENCES treatment_plans(id) ON DELETE CASCADE,
    FOREIGN KEY (treatment_id) REFERENCES treatments(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 💰 MÓDULO: FACTURACIÓN Y PAGOS

#### 40. invoices (Facturas)
```sql
CREATE TABLE invoices (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT NOT NULL,
    invoice_type ENUM('invoice', 'receipt', 'ticket', 'credit_note') DEFAULT 'invoice',
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    series VARCHAR(10),
    folio VARCHAR(20),
    invoice_date DATE NOT NULL,
    due_date DATE,
    status ENUM('draft', 'issued', 'paid', 'partially_paid', 'overdue', 'cancelled') DEFAULT 'draft',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    discount_amount DECIMAL(12,2) DEFAULT 0,
    tax_amount DECIMAL(12,2) DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    amount_paid DECIMAL(12,2) DEFAULT 0,
    balance DECIMAL(12,2) DEFAULT 0,
    currency VARCHAR(3) DEFAULT 'MXN',
    exchange_rate DECIMAL(10,4) DEFAULT 1,
    payment_method VARCHAR(100),
    payment_terms TEXT,
    notes TEXT,
    electronic_invoice_uuid VARCHAR(255) COMMENT 'UUID de factura electrónica',
    electronic_invoice_xml TEXT,
    electronic_invoice_pdf_path VARCHAR(500),
    stamped_at TIMESTAMP NULL COMMENT 'Fecha de timbrado',
    cancelled_at TIMESTAMP NULL,
    cancellation_reason TEXT,
    created_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_invoice_number (invoice_number),
    INDEX idx_status (status),
    INDEX idx_invoice_date (invoice_date),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 41. invoice_items (Ítems de Factura)
```sql
CREATE TABLE invoice_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    invoice_id BIGINT NOT NULL,
    treatment_id BIGINT,
    product_id BIGINT COMMENT 'Si es venta de producto',
    description TEXT NOT NULL,
    quantity DECIMAL(10,2) DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    discount_percentage DECIMAL(5,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    tax_percentage DECIMAL(5,2) DEFAULT 0,
    tax_amount DECIMAL(10,2) DEFAULT 0,
    subtotal DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    sort_order INT DEFAULT 0,

    INDEX idx_invoice (invoice_id),
    INDEX idx_treatment (treatment_id),
    INDEX idx_product (product_id),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (treatment_id) REFERENCES treatments(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 42. payments (Pagos)
```sql
CREATE TABLE payments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT NOT NULL,
    invoice_id BIGINT COMMENT 'Factura a la que aplica (puede ser null para anticipos)',
    payment_number VARCHAR(50) UNIQUE NOT NULL,
    payment_date DATE NOT NULL,
    payment_method_id BIGINT NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'MXN',
    exchange_rate DECIMAL(10,4) DEFAULT 1,
    reference_number VARCHAR(255) COMMENT 'Referencia bancaria, número de cheque, etc.',
    notes TEXT,
    status ENUM('pending', 'completed', 'cancelled', 'refunded') DEFAULT 'completed',
    cancelled_at TIMESTAMP NULL,
    cancellation_reason TEXT,
    received_by BIGINT COMMENT 'FK a users',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_invoice (invoice_id),
    INDEX idx_payment_date (payment_date),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id),
    FOREIGN KEY (received_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 43. payment_methods (Formas de Pago)
```sql
CREATE TABLE payment_methods (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    name VARCHAR(100) NOT NULL,
    type ENUM('cash', 'card', 'transfer', 'check', 'crypto', 'other') NOT NULL,
    requires_reference BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_type (type),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 44. payment_plans (Planes de Financiamiento)
```sql
CREATE TABLE payment_plans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT NOT NULL,
    quote_id BIGINT COMMENT 'Presupuesto asociado',
    invoice_id BIGINT COMMENT 'Factura asociada',
    plan_number VARCHAR(50) UNIQUE NOT NULL,
    plan_name VARCHAR(255),
    total_amount DECIMAL(12,2) NOT NULL,
    down_payment DECIMAL(12,2) DEFAULT 0 COMMENT 'Enganche',
    financed_amount DECIMAL(12,2) NOT NULL COMMENT 'Monto financiado',
    interest_rate DECIMAL(5,2) DEFAULT 0 COMMENT 'Tasa de interés anual',
    number_of_installments INT NOT NULL,
    installment_frequency ENUM('weekly', 'biweekly', 'monthly') DEFAULT 'monthly',
    start_date DATE NOT NULL,
    end_date DATE,
    status ENUM('active', 'completed', 'defaulted', 'cancelled') DEFAULT 'active',
    late_payment_fee DECIMAL(10,2) DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (quote_id) REFERENCES quotes(id),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 45. payment_plan_installments (Cuotas)
```sql
CREATE TABLE payment_plan_installments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    payment_plan_id BIGINT NOT NULL,
    installment_number INT NOT NULL,
    due_date DATE NOT NULL,
    principal_amount DECIMAL(10,2) NOT NULL,
    interest_amount DECIMAL(10,2) DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    amount_paid DECIMAL(10,2) DEFAULT 0,
    balance DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'paid', 'overdue', 'partial') DEFAULT 'pending',
    paid_date DATE,
    payment_id BIGINT COMMENT 'FK a payments',
    late_fee DECIMAL(10,2) DEFAULT 0,
    notes TEXT,

    INDEX idx_payment_plan (payment_plan_id),
    INDEX idx_due_date (due_date),
    INDEX idx_status (status),
    FOREIGN KEY (payment_plan_id) REFERENCES payment_plans(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_id) REFERENCES payments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 📊 MÓDULO: CONTROL FINANCIERO

#### 46. income_categories (Categorías de Ingresos)
```sql
CREATE TABLE income_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 47. incomes (Ingresos)
```sql
CREATE TABLE incomes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    income_category_id BIGINT,
    payment_id BIGINT COMMENT 'Si proviene de un pago',
    income_date DATE NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    description TEXT,
    reference VARCHAR(255),
    notes TEXT,
    created_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_category (income_category_id),
    INDEX idx_income_date (income_date),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (income_category_id) REFERENCES income_categories(id),
    FOREIGN KEY (payment_id) REFERENCES payments(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 48. expense_categories (Categorías de Egresos)
```sql
CREATE TABLE expense_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    parent_id BIGINT COMMENT 'Para categorías jerárquicas',
    name VARCHAR(255) NOT NULL,
    type ENUM('payroll', 'supplies', 'services', 'lab', 'marketing', 'taxes', 'maintenance', 'other') NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_parent (parent_id),
    INDEX idx_type (type),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (parent_id) REFERENCES expense_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 49. expenses (Egresos)
```sql
CREATE TABLE expenses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    expense_category_id BIGINT NOT NULL,
    supplier_id BIGINT COMMENT 'FK a suppliers',
    purchase_order_id BIGINT COMMENT 'FK a purchase_orders',
    expense_number VARCHAR(50) UNIQUE,
    expense_date DATE NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    tax_amount DECIMAL(12,2) DEFAULT 0,
    total_amount DECIMAL(12,2) NOT NULL,
    payment_method_id BIGINT,
    description TEXT NOT NULL,
    invoice_number VARCHAR(100) COMMENT 'Número de factura del proveedor',
    reference VARCHAR(255),
    status ENUM('pending', 'paid', 'cancelled') DEFAULT 'paid',
    notes TEXT,
    approved_by BIGINT COMMENT 'FK a users',
    created_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_category (expense_category_id),
    INDEX idx_supplier (supplier_id),
    INDEX idx_expense_date (expense_date),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (expense_category_id) REFERENCES expense_categories(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
    FOREIGN KEY (purchase_order_id) REFERENCES purchase_orders(id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 50. cash_registers (Cajas)
```sql
CREATE TABLE cash_registers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    register_number VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    UNIQUE KEY unique_clinic_register (clinic_id, register_number),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 51. cash_register_movements (Movimientos de Caja)
```sql
CREATE TABLE cash_register_movements (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    cash_register_id BIGINT NOT NULL,
    movement_type ENUM('opening', 'closing', 'income', 'expense', 'withdrawal', 'deposit') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    balance_before DECIMAL(12,2),
    balance_after DECIMAL(12,2),
    payment_id BIGINT COMMENT 'FK a payments si es ingreso',
    expense_id BIGINT COMMENT 'FK a expenses si es egreso',
    description TEXT,
    reference VARCHAR(255),
    operated_by BIGINT NOT NULL COMMENT 'FK a users',
    operated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,

    INDEX idx_cash_register (cash_register_id),
    INDEX idx_movement_type (movement_type),
    INDEX idx_operated_at (operated_at),
    FOREIGN KEY (cash_register_id) REFERENCES cash_registers(id),
    FOREIGN KEY (payment_id) REFERENCES payments(id),
    FOREIGN KEY (expense_id) REFERENCES expenses(id),
    FOREIGN KEY (operated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 52. bank_reconciliations (Conciliaciones Bancarias)
```sql
CREATE TABLE bank_reconciliations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    bank_account VARCHAR(100) NOT NULL,
    reconciliation_date DATE NOT NULL,
    statement_balance DECIMAL(12,2) NOT NULL,
    book_balance DECIMAL(12,2) NOT NULL,
    difference DECIMAL(12,2) DEFAULT 0,
    status ENUM('in_progress', 'reconciled', 'with_differences') DEFAULT 'in_progress',
    notes TEXT,
    reconciled_by BIGINT,
    reconciled_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_reconciliation_date (reconciliation_date),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (reconciled_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 📦 MÓDULO: INVENTARIO Y COMPRAS

#### 53. product_categories (Categorías de Productos)
```sql
CREATE TABLE product_categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    parent_id BIGINT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_parent (parent_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (parent_id) REFERENCES product_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 54. products (Productos)
```sql
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    category_id BIGINT,
    sku VARCHAR(100) UNIQUE NOT NULL,
    barcode VARCHAR(100),
    name VARCHAR(255) NOT NULL,
    description TEXT,
    product_type ENUM('clinical_supply', 'consumable', 'instrument', 'equipment', 'retail', 'medication') NOT NULL,
    unit_of_measure VARCHAR(50) NOT NULL COMMENT 'Pieza, caja, litro, etc.',
    cost_price DECIMAL(10,2),
    selling_price DECIMAL(10,2),
    minimum_stock DECIMAL(10,2) DEFAULT 0,
    maximum_stock DECIMAL(10,2),
    reorder_point DECIMAL(10,2),
    current_stock DECIMAL(10,2) DEFAULT 0,
    requires_batch_tracking BOOLEAN DEFAULT FALSE,
    requires_expiry_tracking BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    image_url VARCHAR(500),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_category (category_id),
    INDEX idx_sku (sku),
    INDEX idx_barcode (barcode),
    INDEX idx_name (name),
    INDEX idx_product_type (product_type),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (category_id) REFERENCES product_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 55. warehouses (Almacenes)
```sql
CREATE TABLE warehouses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 56. inventory_movements (Movimientos de Inventario)
```sql
CREATE TABLE inventory_movements (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    warehouse_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    movement_type ENUM('purchase', 'consumption', 'adjustment', 'transfer', 'return', 'loss') NOT NULL,
    quantity DECIMAL(10,2) NOT NULL COMMENT 'Positivo para entradas, negativo para salidas',
    unit_cost DECIMAL(10,2),
    total_cost DECIMAL(10,2),
    batch_number VARCHAR(100),
    expiry_date DATE,
    stock_before DECIMAL(10,2),
    stock_after DECIMAL(10,2),
    reference_type VARCHAR(100) COMMENT 'purchase_order, appointment, etc.',
    reference_id BIGINT,
    reason TEXT,
    performed_by BIGINT NOT NULL COMMENT 'FK a users',
    performed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_warehouse (warehouse_id),
    INDEX idx_product (product_id),
    INDEX idx_movement_type (movement_type),
    INDEX idx_performed_at (performed_at),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (performed_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 57. suppliers (Proveedores)
```sql
CREATE TABLE suppliers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    supplier_number VARCHAR(50) UNIQUE,
    company_name VARCHAR(255) NOT NULL,
    contact_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    mobile VARCHAR(20),
    address TEXT,
    city_id BIGINT,
    postal_code VARCHAR(10),
    tax_id VARCHAR(50) COMMENT 'RFC/NIT/RUC',
    payment_terms VARCHAR(255) COMMENT 'Condiciones de pago',
    credit_limit DECIMAL(12,2),
    delivery_time_days INT COMMENT 'Tiempo de entrega en días',
    rating DECIMAL(3,2) COMMENT 'Calificación del proveedor 0-5',
    is_active BOOLEAN DEFAULT TRUE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_supplier_number (supplier_number),
    INDEX idx_company_name (company_name),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (city_id) REFERENCES cities(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 58. purchase_orders (Órdenes de Compra)
```sql
CREATE TABLE purchase_orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    supplier_id BIGINT NOT NULL,
    warehouse_id BIGINT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    order_date DATE NOT NULL,
    expected_delivery_date DATE,
    actual_delivery_date DATE,
    status ENUM('draft', 'sent', 'confirmed', 'partial', 'received', 'cancelled') DEFAULT 'draft',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax_amount DECIMAL(12,2) DEFAULT 0,
    shipping_cost DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    payment_terms VARCHAR(255),
    notes TEXT,
    received_by BIGINT COMMENT 'FK a users',
    created_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_supplier (supplier_id),
    INDEX idx_warehouse (warehouse_id),
    INDEX idx_order_number (order_number),
    INDEX idx_status (status),
    INDEX idx_order_date (order_date),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
    FOREIGN KEY (received_by) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 59. purchase_order_items (Ítems de Orden de Compra)
```sql
CREATE TABLE purchase_order_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    purchase_order_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    quantity_ordered DECIMAL(10,2) NOT NULL,
    quantity_received DECIMAL(10,2) DEFAULT 0,
    unit_price DECIMAL(10,2) NOT NULL,
    tax_percentage DECIMAL(5,2) DEFAULT 0,
    tax_amount DECIMAL(10,2) DEFAULT 0,
    subtotal DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    batch_number VARCHAR(100),
    expiry_date DATE,
    notes TEXT,

    INDEX idx_purchase_order (purchase_order_id),
    INDEX idx_product (product_id),
    FOREIGN KEY (purchase_order_id) REFERENCES purchase_orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 🔬 MÓDULO: LABORATORIO DENTAL

#### 60. dental_labs (Laboratorios Externos)
```sql
CREATE TABLE dental_labs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    lab_number VARCHAR(50) UNIQUE,
    name VARCHAR(255) NOT NULL,
    contact_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    mobile VARCHAR(20),
    address TEXT,
    city_id BIGINT,
    postal_code VARCHAR(10),
    specialties TEXT COMMENT 'Especialidades del laboratorio',
    average_delivery_time_days INT,
    quality_rating DECIMAL(3,2) COMMENT 'Calificación 0-5',
    payment_terms VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_name (name),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (city_id) REFERENCES cities(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 61. prosthetic_types (Tipos de Prótesis)
```sql
CREATE TABLE prosthetic_types (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    name VARCHAR(255) NOT NULL,
    category ENUM('crown', 'bridge', 'denture', 'implant', 'veneer', 'orthodontic', 'other') NOT NULL,
    description TEXT,
    default_cost DECIMAL(10,2),
    default_delivery_days INT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_category (category),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 62. lab_orders (Órdenes de Laboratorio)
```sql
CREATE TABLE lab_orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    dental_lab_id BIGINT COMMENT 'FK a dental_labs (null si es interno)',
    prosthetic_type_id BIGINT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    order_date DATE NOT NULL,
    impression_date DATE COMMENT 'Fecha de toma de impresión',
    expected_delivery_date DATE,
    actual_delivery_date DATE,
    try_in_date DATE COMMENT 'Fecha de prueba',
    installation_date DATE COMMENT 'Fecha de instalación',
    status ENUM('requested', 'in_process', 'ready_for_try_in', 'in_adjustments', 'ready', 'delivered', 'installed', 'rejected') DEFAULT 'requested',
    teeth_numbers TEXT NOT NULL COMMENT 'Dientes involucrados',
    shade VARCHAR(50) COMMENT 'Color/tono',
    material VARCHAR(255) COMMENT 'Material de la prótesis',
    specifications TEXT COMMENT 'Especificaciones técnicas',
    cost DECIMAL(10,2),
    rejection_reason TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id),
    INDEX idx_dental_lab (dental_lab_id),
    INDEX idx_order_number (order_number),
    INDEX idx_status (status),
    INDEX idx_order_date (order_date),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id),
    FOREIGN KEY (dental_lab_id) REFERENCES dental_labs(id),
    FOREIGN KEY (prosthetic_type_id) REFERENCES prosthetic_types(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 63. lab_order_photos (Fotos de Trabajos)
```sql
CREATE TABLE lab_order_photos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    lab_order_id BIGINT NOT NULL,
    photo_type ENUM('impression', 'work_in_progress', 'finished', 'try_in', 'installed', 'other') NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    thumbnail_path VARCHAR(500),
    description TEXT,
    taken_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_lab_order (lab_order_id),
    INDEX idx_photo_type (photo_type),
    FOREIGN KEY (lab_order_id) REFERENCES lab_orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 64. lab_evaluations (Evaluaciones de Calidad)
```sql
CREATE TABLE lab_evaluations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    lab_order_id BIGINT NOT NULL,
    dental_lab_id BIGINT NOT NULL,
    quality_rating DECIMAL(3,2) NOT NULL COMMENT 'Calificación 0-5',
    delivery_time_rating DECIMAL(3,2),
    communication_rating DECIMAL(3,2),
    overall_rating DECIMAL(3,2),
    comments TEXT,
    evaluated_by BIGINT NOT NULL COMMENT 'FK a users',
    evaluated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_lab_order (lab_order_id),
    INDEX idx_dental_lab (dental_lab_id),
    FOREIGN KEY (lab_order_id) REFERENCES lab_orders(id),
    FOREIGN KEY (dental_lab_id) REFERENCES dental_labs(id),
    FOREIGN KEY (evaluated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 📈 MÓDULO: AUDITORÍA, COMUNICACIÓN Y CATÁLOGOS

#### 65. audit_logs (Logs de Auditoría)
```sql
CREATE TABLE audit_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    clinic_id BIGINT,
    action VARCHAR(100) NOT NULL COMMENT 'create, update, delete, login, etc.',
    entity_type VARCHAR(100) COMMENT 'Tipo de entidad afectada',
    entity_id BIGINT COMMENT 'ID de la entidad afectada',
    old_values JSON COMMENT 'Valores anteriores',
    new_values JSON COMMENT 'Valores nuevos',
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_user (user_id),
    INDEX idx_clinic (clinic_id),
    INDEX idx_action (action),
    INDEX idx_entity (entity_type, entity_id),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 66. system_logs (Logs del Sistema)
```sql
CREATE TABLE system_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    level ENUM('debug', 'info', 'warning', 'error', 'critical') NOT NULL,
    message TEXT NOT NULL,
    context JSON,
    source VARCHAR(255) COMMENT 'Origen del log',
    stack_trace TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_level (level),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 67. notifications (Notificaciones)
```sql
CREATE TABLE notifications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    type VARCHAR(100) NOT NULL COMMENT 'appointment, payment, task, etc.',
    title VARCHAR(255) NOT NULL,
    message TEXT,
    data JSON COMMENT 'Datos adicionales',
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_user (user_id),
    INDEX idx_type (type),
    INDEX idx_is_read (is_read),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 68. whatsapp_messages (Mensajes WhatsApp)
```sql
CREATE TABLE whatsapp_messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT,
    phone_number VARCHAR(20) NOT NULL,
    message_type ENUM('reminder', 'notification', 'marketing', 'conversation') NOT NULL,
    message TEXT NOT NULL,
    template_name VARCHAR(255),
    status ENUM('pending', 'sent', 'delivered', 'read', 'failed') DEFAULT 'pending',
    external_id VARCHAR(255) COMMENT 'ID del mensaje en la API de WhatsApp',
    error_message TEXT,
    sent_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    read_at TIMESTAMP NULL,
    response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 69. email_messages (Emails)
```sql
CREATE TABLE email_messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT,
    email_to VARCHAR(255) NOT NULL,
    email_cc TEXT,
    email_bcc TEXT,
    subject VARCHAR(500) NOT NULL,
    body TEXT NOT NULL,
    is_html BOOLEAN DEFAULT TRUE,
    attachments JSON,
    status ENUM('pending', 'sent', 'delivered', 'bounced', 'failed') DEFAULT 'pending',
    error_message TEXT,
    sent_at TIMESTAMP NULL,
    opened_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 70. sms_messages (SMS)
```sql
CREATE TABLE sms_messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT NOT NULL,
    patient_id BIGINT,
    phone_number VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'sent', 'delivered', 'failed') DEFAULT 'pending',
    external_id VARCHAR(255),
    error_message TEXT,
    sent_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 71. appointment_cancellation_reasons (Motivos de Cancelación)
```sql
CREATE TABLE appointment_cancellation_reasons (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    reason VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 72. patient_sources (Origen de Pacientes)
```sql
CREATE TABLE patient_sources (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT,
    name VARCHAR(255) NOT NULL COMMENT 'Referido, Facebook, Google, etc.',
    type ENUM('referral', 'social_media', 'search_engine', 'advertising', 'walk_in', 'other') NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_type (type),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 73. specialties (Especialidades)
```sql
CREATE TABLE specialties (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 74. countries (Países)
```sql
CREATE TABLE countries (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(2) UNIQUE NOT NULL COMMENT 'Código ISO 3166-1 alpha-2',
    name VARCHAR(255) NOT NULL,
    phone_code VARCHAR(10),
    is_active BOOLEAN DEFAULT TRUE,

    INDEX idx_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 75. states (Estados/Provincias)
```sql
CREATE TABLE states (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    country_id BIGINT NOT NULL,
    code VARCHAR(10),
    name VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,

    INDEX idx_country (country_id),
    INDEX idx_code (code),
    FOREIGN KEY (country_id) REFERENCES countries(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 76. cities (Ciudades)
```sql
CREATE TABLE cities (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    state_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,

    INDEX idx_state (state_id),
    INDEX idx_name (name),
    FOREIGN KEY (state_id) REFERENCES states(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## ÍNDICES Y OPTIMIZACIONES

### Estrategias de Indexación Aplicadas

1. **Índices en Claves Foráneas**: Todas las FK tienen índice para optimizar JOINs
2. **Índices en Campos de Búsqueda**: name, email, phone, code, etc.
3. **Índices en Campos de Filtrado**: status, is_active, type, etc.
4. **Índices en Campos de Fechas**: created_at, appointment_date, etc.
5. **Índices Compuestos**: Para búsquedas comunes (fecha + status, clinic + patient, etc.)

### Consideraciones de Performance

1. **Particionamiento**: Tablas grandes como `audit_logs` y `system_logs` deben particionarse por fecha
2. **Archivado**: Implementar archivado automático de registros antiguos
3. **Caching**: Usar Redis/Memcached para catálogos y configuraciones
4. **Read Replicas**: Para reportes y analítica usar réplicas de lectura
5. **Soft Deletes**: Uso de `deleted_at` en lugar de eliminar registros físicamente

### Consideraciones de Seguridad

1. **Cifrado**: Datos sensibles deben cifrarse (alergias, medicamentos, historial médico)
2. **Backups**: Backup diario con retención de 30 días mínimo
3. **Auditoría**: Log completo de accesos y modificaciones a datos médicos
4. **HIPAA/GDPR Compliance**: Cumplimiento de normativas de protección de datos

---

## RESUMEN DEL DISEÑO

### Métricas del Diseño
- **Total de Tablas**: 76
- **Total de Relaciones**: ~150 claves foráneas
- **Módulos Cubiertos**: 11 módulos principales
- **Tipos de Relaciones**:
  - One-to-Many: ~70%
  - Many-to-Many: ~15%
  - One-to-One: ~15%

### Capacidad del Sistema
- **Escalabilidad**: Diseñado para manejar múltiples clínicas
- **Concurrencia**: Optimizado para acceso simultáneo
- **Histórico**: Mantiene historial completo con soft deletes
- **Auditoría**: Trazabilidad completa de cambios

### Tecnologías Recomendadas
- **Base de Datos**: MySQL 8.0+ / PostgreSQL 14+
- **Cache**: Redis
- **Search Engine**: Elasticsearch (para búsqueda avanzada)
- **File Storage**: Amazon S3 / MinIO
- **Queue**: RabbitMQ / Redis Queue

---

*Documento generado por INNOVADENT - Sistema Integral de Gestión Dental*
*Versión 1.0 - 2025*
