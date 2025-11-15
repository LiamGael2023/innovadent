-- =====================================================
-- INNOVADENT - Schema de Base de Datos MySQL
-- Sistema de Gestión Dental
-- Versión: 1.0.0
-- =====================================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS innovadent CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE innovadent;

-- =====================================================
-- MÓDULO: CONFIGURACIÓN Y MULTIEMPRESA
-- =====================================================

-- Tabla: clinics
CREATE TABLE clinics (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(20) UNIQUE NOT NULL COMMENT 'Código único de la clínica',
    name VARCHAR(255) NOT NULL COMMENT 'Nombre comercial',
    legal_name VARCHAR(255) COMMENT 'Razón social',
    tax_id VARCHAR(50) COMMENT 'RFC/NIT/RUC/Tax ID',
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    postal_code VARCHAR(10),
    logo_url VARCHAR(500) COMMENT 'URL del logo',
    primary_color VARCHAR(7) DEFAULT '#0066CC' COMMENT 'Color corporativo',
    timezone VARCHAR(50) DEFAULT 'America/Mexico_City',
    currency VARCHAR(3) DEFAULT 'MXN',
    is_active BOOLEAN DEFAULT TRUE,
    is_main BOOLEAN DEFAULT FALSE,
    settings JSON COMMENT 'Configuraciones específicas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    INDEX idx_code (code),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: users
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    photo_url VARCHAR(500),
    employee_number VARCHAR(50),
    professional_license VARCHAR(100) COMMENT 'Cédula profesional',
    is_doctor BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    two_factor_enabled BOOLEAN DEFAULT FALSE,
    preferences JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    INDEX idx_clinic (clinic_id),
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_is_doctor (is_doctor),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: roles
CREATE TABLE roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    is_system BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: user_roles
CREATE TABLE user_roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_user_role (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- MÓDULO: PACIENTES
-- =====================================================

-- Tabla: patients
CREATE TABLE patients (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED NOT NULL,
    patient_number VARCHAR(50) UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    second_last_name VARCHAR(100),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other') NOT NULL,
    blood_type VARCHAR(5),
    email VARCHAR(255),
    phone VARCHAR(20),
    mobile VARCHAR(20),
    address TEXT,
    postal_code VARCHAR(10),
    occupation VARCHAR(100),
    referred_by VARCHAR(255),
    photo_url VARCHAR(500),
    notes TEXT,
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
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: medical_histories
CREATE TABLE medical_histories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT UNSIGNED NOT NULL UNIQUE,
    has_systemic_diseases BOOLEAN DEFAULT FALSE,
    systemic_diseases TEXT,
    has_allergies BOOLEAN DEFAULT FALSE,
    allergies TEXT,
    current_medications TEXT,
    is_pregnant BOOLEAN DEFAULT FALSE,
    is_smoker BOOLEAN DEFAULT FALSE,
    consumes_alcohol BOOLEAN DEFAULT FALSE,
    dental_history TEXT,
    brushing_frequency VARCHAR(100),
    last_dental_visit DATE,
    fears_or_anxieties TEXT,
    additional_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- MÓDULO: CITAS
-- =====================================================

-- Tabla: appointment_types
CREATE TABLE appointment_types (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(7) DEFAULT '#0066CC',
    default_duration_minutes INT DEFAULT 30,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: appointments
CREATE TABLE appointments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED NOT NULL,
    patient_id BIGINT UNSIGNED NOT NULL,
    doctor_id BIGINT UNSIGNED NOT NULL,
    appointment_type_id BIGINT UNSIGNED,
    appointment_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    duration_minutes INT NOT NULL DEFAULT 30,
    status ENUM('scheduled', 'confirmed', 'waiting', 'in_progress', 'completed', 'cancelled', 'no_show') DEFAULT 'scheduled',
    chair_number VARCHAR(20),
    reason TEXT,
    notes TEXT,
    confirmed_at TIMESTAMP NULL,
    arrived_at TIMESTAMP NULL,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_doctor (doctor_id),
    INDEX idx_appointment_date (appointment_date),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_type_id) REFERENCES appointment_types(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- MÓDULO: TRATAMIENTOS
-- =====================================================

-- Tabla: treatment_categories
CREATE TABLE treatment_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED,
    parent_id BIGINT UNSIGNED,
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
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES treatment_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: treatments
CREATE TABLE treatments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED,
    code VARCHAR(50) UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    default_price DECIMAL(10,2) NOT NULL,
    cost DECIMAL(10,2),
    duration_minutes INT DEFAULT 30,
    requires_lab BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_category (category_id),
    INDEX idx_code (code),
    INDEX idx_name (name),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES treatment_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- MÓDULO: FACTURACIÓN
-- =====================================================

-- Tabla: payment_methods
CREATE TABLE payment_methods (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED,
    name VARCHAR(100) NOT NULL,
    type ENUM('cash', 'card', 'transfer', 'check', 'other') NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: invoices
CREATE TABLE invoices (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED NOT NULL,
    patient_id BIGINT UNSIGNED NOT NULL,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    invoice_date DATE NOT NULL,
    due_date DATE,
    status ENUM('draft', 'issued', 'paid', 'partially_paid', 'overdue', 'cancelled') DEFAULT 'draft',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    discount_amount DECIMAL(12,2) DEFAULT 0,
    tax_amount DECIMAL(12,2) DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    amount_paid DECIMAL(12,2) DEFAULT 0,
    balance DECIMAL(12,2) DEFAULT 0,
    notes TEXT,
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_invoice_number (invoice_number),
    INDEX idx_status (status),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: payments
CREATE TABLE payments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    clinic_id BIGINT UNSIGNED NOT NULL,
    patient_id BIGINT UNSIGNED NOT NULL,
    invoice_id BIGINT UNSIGNED,
    payment_method_id BIGINT UNSIGNED NOT NULL,
    payment_number VARCHAR(50) UNIQUE NOT NULL,
    payment_date DATE NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    reference_number VARCHAR(255),
    notes TEXT,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'completed',
    received_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_clinic (clinic_id),
    INDEX idx_patient (patient_id),
    INDEX idx_invoice (invoice_id),
    INDEX idx_payment_date (payment_date),
    FOREIGN KEY (clinic_id) REFERENCES clinics(id) ON DELETE CASCADE,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE SET NULL,
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id) ON DELETE CASCADE,
    FOREIGN KEY (received_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATOS INICIALES
-- =====================================================

-- Insertar clínica principal
INSERT INTO clinics (code, name, legal_name, email, phone, is_main, is_active)
VALUES ('MAIN001', 'Clínica Dental Principal', 'Innovadent S.A. de C.V.', 'info@innovadent.com', '555-1234', TRUE, TRUE);

-- Insertar roles
INSERT INTO roles (name, slug, description, is_system) VALUES
('Administrador', 'admin', 'Control total del sistema', TRUE),
('Doctor', 'doctor', 'Acceso a funciones clínicas', TRUE),
('Recepcionista', 'receptionist', 'Gestión de citas y pacientes', TRUE),
('Asistente', 'assistant', 'Apoyo en consultas', TRUE);

-- Insertar usuario admin por defecto
-- Password: admin123 (debe cambiarse en producción)
INSERT INTO users (clinic_id, username, email, password_hash, first_name, last_name, is_doctor, is_active)
VALUES (1, 'admin', 'admin@innovadent.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'Sistema', FALSE, TRUE);

-- Asignar rol admin al usuario
INSERT INTO user_roles (user_id, role_id) VALUES (1, 1);

-- Insertar tipos de cita
INSERT INTO appointment_types (clinic_id, name, color, default_duration_minutes) VALUES
(1, 'Consulta General', '#0066CC', 30),
(1, 'Limpieza Dental', '#00CC66', 45),
(1, 'Endodoncia', '#CC6600', 60),
(1, 'Extracción', '#CC0000', 45),
(1, 'Ortodoncia', '#6600CC', 30),
(1, 'Emergencia', '#FF0000', 30);

-- Insertar categorías de tratamientos
INSERT INTO treatment_categories (clinic_id, name, description, color) VALUES
(1, 'Preventiva', 'Tratamientos preventivos', '#00CC66'),
(1, 'Restauradora', 'Restauraciones dentales', '#0066CC'),
(1, 'Endodoncia', 'Tratamientos de conducto', '#CC6600'),
(1, 'Cirugía', 'Procedimientos quirúrgicos', '#CC0000'),
(1, 'Ortodoncia', 'Corrección de posición dental', '#6600CC'),
(1, 'Prótesis', 'Prótesis dentales', '#CC00CC');

-- Insertar tratamientos comunes
INSERT INTO treatments (clinic_id, category_id, code, name, default_price, duration_minutes) VALUES
(1, 1, 'PREV001', 'Limpieza Dental', 500.00, 45),
(1, 1, 'PREV002', 'Aplicación de Flúor', 300.00, 15),
(1, 2, 'REST001', 'Resina Simple', 800.00, 30),
(1, 2, 'REST002', 'Resina Compuesta', 1200.00, 45),
(1, 3, 'ENDO001', 'Endodoncia Unirradicular', 2500.00, 60),
(1, 3, 'ENDO002', 'Endodoncia Multirradicular', 3500.00, 90),
(1, 4, 'CIRUG001', 'Extracción Simple', 600.00, 30),
(1, 4, 'CIRUG002', 'Extracción Compleja', 1200.00, 60);

-- Insertar métodos de pago
INSERT INTO payment_methods (clinic_id, name, type, is_active) VALUES
(1, 'Efectivo', 'cash', TRUE),
(1, 'Tarjeta de Crédito', 'card', TRUE),
(1, 'Tarjeta de Débito', 'card', TRUE),
(1, 'Transferencia', 'transfer', TRUE);
