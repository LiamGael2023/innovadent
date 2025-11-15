# INNOVADENT - Diagrama Entidad-Relación (ERD)

## Diagramas de Relaciones por Módulo

Este documento contiene los diagramas ERD de cada módulo del sistema INNOVADENT usando sintaxis Mermaid.

---

## 1. MÓDULO: CONFIGURACIÓN Y MULTIEMPRESA

```mermaid
erDiagram
    clinics ||--o{ users : "tiene"
    clinics ||--o{ user_roles : "tiene"
    users ||--o{ user_roles : "tiene"
    users }o--|| specialties : "pertenece_a"
    roles ||--o{ role_permissions : "tiene"
    permissions ||--o{ role_permissions : "tiene"
    roles ||--o{ user_roles : "asignado_a"
    cities }o--|| states : "pertenece_a"
    states }o--|| countries : "pertenece_a"
    clinics }o--o| cities : "ubicada_en"

    clinics {
        bigint id PK
        varchar code UK
        varchar name
        varchar legal_name
        varchar tax_id
        varchar email
        varchar phone
        text address
        bigint city_id FK
        varchar logo_url
        varchar primary_color
        boolean is_active
        boolean is_main
        json settings
    }

    users {
        bigint id PK
        bigint clinic_id FK
        varchar username UK
        varchar email UK
        varchar password_hash
        varchar first_name
        varchar last_name
        varchar phone
        bigint specialty_id FK
        varchar professional_license
        boolean is_doctor
        boolean is_active
        boolean two_factor_enabled
        json preferences
    }

    roles {
        bigint id PK
        varchar name
        varchar slug UK
        text description
        boolean is_system
    }

    permissions {
        bigint id PK
        varchar module
        varchar action
        varchar name
        varchar slug UK
    }
```

---

## 2. MÓDULO: PACIENTES

```mermaid
erDiagram
    patients ||--o{ patient_contacts : "tiene"
    patients ||--o{ patient_insurances : "tiene"
    patients ||--o{ patient_documents : "tiene"
    patients ||--o{ patient_photos : "tiene"
    patients }o--|| clinics : "pertenece_a"
    patients }o--o| cities : "vive_en"
    patients }o--o| patient_sources : "origen"
    users ||--o{ patient_documents : "sube"
    users ||--o{ patient_photos : "toma"

    patients {
        bigint id PK
        bigint clinic_id FK
        varchar patient_number UK
        varchar first_name
        varchar last_name
        date date_of_birth
        enum gender
        varchar blood_type
        varchar email
        varchar phone
        varchar mobile
        text address
        bigint city_id FK
        bigint patient_source_id FK
        varchar photo_url
        text notes
        boolean is_active
        date last_visit_date
        date next_visit_date
    }

    patient_contacts {
        bigint id PK
        bigint patient_id FK
        varchar name
        varchar relationship
        varchar phone
        varchar mobile
        boolean is_emergency_contact
        boolean is_primary
    }

    patient_insurances {
        bigint id PK
        bigint patient_id FK
        varchar insurance_company
        varchar policy_number
        date start_date
        date end_date
        text coverage_details
        boolean is_active
    }

    patient_documents {
        bigint id PK
        bigint patient_id FK
        varchar document_type
        varchar file_name
        varchar file_path
        varchar file_type
        bigint file_size
        text description
        bigint uploaded_by FK
    }

    patient_photos {
        bigint id PK
        bigint patient_id FK
        bigint appointment_id FK
        enum photo_type
        varchar photo_category
        varchar file_path
        varchar thumbnail_path
        timestamp taken_at
        bigint taken_by FK
    }
```

---

## 3. MÓDULO: AGENDA Y CITAS

```mermaid
erDiagram
    appointments }o--|| clinics : "en"
    appointments }o--|| patients : "para"
    appointments }o--|| users : "con_doctor"
    appointments }o--o| appointment_types : "tipo"
    appointments }o--o| appointment_cancellation_reasons : "motivo_cancelacion"
    appointments ||--o{ appointment_reminders : "tiene"
    appointments ||--o| waiting_room : "en_sala_espera"
    working_hours }o--|| clinics : "de"
    working_hours }o--o| users : "doctor"

    appointments {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        bigint doctor_id FK
        bigint appointment_type_id FK
        date appointment_date
        time start_time
        time end_time
        int duration_minutes
        enum status
        varchar chair_number
        text reason
        text notes
        bigint cancellation_reason_id FK
        text cancellation_notes
        bigint cancelled_by FK
        timestamp confirmed_at
        timestamp arrived_at
        timestamp started_at
        timestamp completed_at
    }

    appointment_types {
        bigint id PK
        bigint clinic_id FK
        varchar name
        varchar color
        int default_duration_minutes
        boolean is_active
    }

    appointment_reminders {
        bigint id PK
        bigint appointment_id FK
        enum reminder_type
        varchar recipient
        text message
        timestamp scheduled_at
        timestamp sent_at
        enum status
        text response
    }

    working_hours {
        bigint id PK
        bigint clinic_id FK
        bigint doctor_id FK
        tinyint day_of_week
        time start_time
        time end_time
        boolean is_active
        date effective_from
        date effective_to
    }

    waiting_room {
        bigint id PK
        bigint appointment_id FK
        int queue_number
        timestamp checked_in_at
        int estimated_wait_minutes
        timestamp called_at
        enum status
    }
```

---

## 4. MÓDULO: HISTORIA CLÍNICA

```mermaid
erDiagram
    patients ||--o| medical_histories : "tiene"
    patients ||--o{ clinical_notes : "tiene"
    patients ||--o{ vital_signs : "tiene"
    patients ||--o{ allergies : "tiene"
    patients ||--o{ medications : "tiene"
    patients ||--o{ informed_consents : "firma"
    appointments ||--o{ clinical_notes : "genera"
    appointments ||--o{ vital_signs : "registra"
    users ||--o{ clinical_notes : "escribe"
    users ||--o{ vital_signs : "toma"
    users ||--o{ informed_consents : "solicita"
    treatments ||--o{ informed_consents : "para"

    medical_histories {
        bigint id PK
        bigint patient_id FK_UK
        boolean has_systemic_diseases
        text systemic_diseases
        boolean has_heart_disease
        text heart_disease_details
        boolean has_respiratory_disease
        boolean has_kidney_disease
        boolean has_bleeding_disorders
        boolean is_pregnant
        int pregnancy_weeks
        boolean is_smoker
        varchar smoking_frequency
        boolean consumes_alcohol
        text previous_surgeries
        text dental_history
        text dental_hygiene_habits
        varchar brushing_frequency
        date last_dental_visit
        text fears_or_anxieties
        text additional_notes
    }

    clinical_notes {
        bigint id PK
        bigint patient_id FK
        bigint appointment_id FK
        bigint doctor_id FK
        enum note_type
        varchar subject
        text content
    }

    vital_signs {
        bigint id PK
        bigint patient_id FK
        bigint appointment_id FK
        int blood_pressure_systolic
        int blood_pressure_diastolic
        int heart_rate
        decimal temperature
        int respiratory_rate
        decimal oxygen_saturation
        decimal glucose
        decimal weight
        decimal height
        bigint measured_by FK
        timestamp measured_at
    }

    allergies {
        bigint id PK
        bigint patient_id FK
        varchar allergen
        enum allergen_type
        text reaction
        enum severity
        date diagnosed_date
        boolean is_active
    }

    medications {
        bigint id PK
        bigint patient_id FK
        varchar medication_name
        varchar dosage
        varchar frequency
        enum route
        text reason
        date start_date
        date end_date
        boolean is_current
        varchar prescribed_by
    }

    informed_consents {
        bigint id PK
        bigint patient_id FK
        bigint treatment_id FK
        varchar title
        text content
        timestamp signed_at
        text signature_data
        varchar witness_name
        text witness_signature_data
        bigint doctor_id FK
        varchar document_path
    }
```

---

## 5. MÓDULO: ODONTOGRAMA Y PERIODONTOGRAMA

```mermaid
erDiagram
    patients ||--o{ odontograms : "tiene"
    patients ||--o{ periodontograms : "tiene"
    appointments ||--o{ odontograms : "genera"
    appointments ||--o{ periodontograms : "genera"
    users ||--o{ odontograms : "crea"
    users ||--o{ periodontograms : "crea"
    odontograms ||--o{ odontogram_teeth : "contiene"
    odontogram_teeth ||--o{ odontogram_conditions : "tiene"
    periodontograms ||--o{ periodontal_measurements : "contiene"

    odontograms {
        bigint id PK
        bigint patient_id FK
        bigint appointment_id FK
        bigint doctor_id FK
        enum nomenclature
        text notes
    }

    odontogram_teeth {
        bigint id PK
        bigint odontogram_id FK
        varchar tooth_number
        enum tooth_type
        boolean is_present
        enum absence_reason
        enum mobility
        text notes
    }

    odontogram_conditions {
        bigint id PK
        bigint odontogram_tooth_id FK
        enum condition_type
        varchar surface
        varchar material
        enum status
        enum severity
        varchar color
        text notes
        timestamp recorded_at
    }

    periodontograms {
        bigint id PK
        bigint patient_id FK
        bigint appointment_id FK
        bigint doctor_id FK
        decimal oleary_index
        decimal ihos_index
        text diagnosis
        text treatment_plan
        text notes
    }

    periodontal_measurements {
        bigint id PK
        bigint periodontogram_id FK
        varchar tooth_number
        enum position
        enum aspect
        int probing_depth
        int gingival_margin
        int clinical_attachment_level
        boolean bleeding_on_probing
        boolean plaque_present
        int gingival_recession
        enum furcation
    }
```

---

## 6. MÓDULO: ORTODONCIA

```mermaid
erDiagram
    patients ||--o{ orthodontic_cases : "tiene"
    users ||--o{ orthodontic_cases : "atiende"
    orthodontic_cases ||--o{ orthodontic_photos : "tiene"
    orthodontic_cases ||--o{ orthodontic_activations : "tiene"
    orthodontic_cases ||--o{ cephalometric_analyses : "tiene"
    orthodontic_cases ||--o{ orthodontic_appliances : "usa"
    appointments ||--o{ orthodontic_activations : "registra"

    orthodontic_cases {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        varchar case_number UK
        date start_date
        date estimated_end_date
        date actual_end_date
        enum status
        enum treatment_type
        text chief_complaint
        text diagnosis
        text treatment_plan
        text extraction_plan
        text notes
    }

    orthodontic_photos {
        bigint id PK
        bigint orthodontic_case_id FK
        enum photo_type
        varchar file_path
        varchar thumbnail_path
        text description
        date taken_at
    }

    orthodontic_activations {
        bigint id PK
        bigint orthodontic_case_id FK
        bigint appointment_id FK
        date activation_date
        enum arch
        varchar wire_type
        varchar wire_size
        text elastics_configuration
        text brackets_placed
        text brackets_removed
        text procedures_performed
        int next_appointment_weeks
        text notes
    }

    cephalometric_analyses {
        bigint id PK
        bigint orthodontic_case_id FK
        date analysis_date
        varchar analysis_type
        decimal sna_angle
        decimal snb_angle
        decimal anb_angle
        decimal facial_angle
        decimal y_axis
        json measurements
        text interpretation
        varchar image_path
    }

    orthodontic_appliances {
        bigint id PK
        bigint orthodontic_case_id FK
        enum appliance_type
        varchar appliance_name
        date installed_date
        date removed_date
        boolean is_active
        text notes
    }
```

---

## 7. MÓDULO: TRATAMIENTOS Y PRESUPUESTOS

```mermaid
erDiagram
    clinics ||--o{ treatment_categories : "tiene"
    treatment_categories ||--o{ treatment_categories : "padre_de"
    treatment_categories ||--o{ treatments : "contiene"
    clinics ||--o{ treatments : "ofrece"
    treatments ||--o{ treatment_materials : "requiere"
    products ||--o{ treatment_materials : "usado_en"
    quotes }o--|| clinics : "de"
    quotes }o--|| patients : "para"
    quotes }o--|| users : "elaborado_por"
    quotes ||--o{ quote_items : "contiene"
    quote_items }o--|| treatments : "incluye"
    treatment_plans }o--|| clinics : "de"
    treatment_plans }o--|| patients : "para"
    treatment_plans }o--|| users : "elaborado_por"
    treatment_plans }o--o| quotes : "basado_en"
    treatment_plans ||--o{ treatment_plan_items : "contiene"
    treatment_plan_items }o--|| treatments : "incluye"
    treatment_plan_items }o--o| appointments : "realizado_en"

    treatment_categories {
        bigint id PK
        bigint clinic_id FK
        bigint parent_id FK
        varchar name
        text description
        varchar icon
        varchar color
        int sort_order
        boolean is_active
    }

    treatments {
        bigint id PK
        bigint clinic_id FK
        bigint category_id FK
        varchar code UK
        varchar name
        text description
        decimal default_price
        decimal cost
        int duration_minutes
        boolean requires_lab
        boolean is_package
        varchar image_url
        text instructions
        boolean is_active
    }

    treatment_materials {
        bigint id PK
        bigint treatment_id FK
        bigint product_id FK
        decimal quantity
        varchar unit
        text notes
    }

    quotes {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        bigint doctor_id FK
        varchar quote_number UK
        date quote_date
        date valid_until
        enum status
        decimal subtotal
        decimal discount_percentage
        decimal discount_amount
        decimal tax_percentage
        decimal tax_amount
        decimal total
        text notes
        text terms_and_conditions
        timestamp approved_at
        timestamp rejected_at
        bigint created_by FK
    }

    quote_items {
        bigint id PK
        bigint quote_id FK
        bigint treatment_id FK
        varchar tooth_number
        int quantity
        decimal unit_price
        decimal discount_percentage
        decimal discount_amount
        decimal subtotal
        text notes
        int sort_order
    }

    treatment_plans {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        bigint doctor_id FK
        bigint quote_id FK
        varchar plan_number UK
        varchar plan_name
        date start_date
        date estimated_end_date
        date actual_end_date
        enum status
        enum priority
        decimal total_estimated_cost
        decimal total_actual_cost
        decimal completion_percentage
        text notes
    }

    treatment_plan_items {
        bigint id PK
        bigint treatment_plan_id FK
        bigint treatment_id FK
        bigint appointment_id FK
        varchar tooth_number
        enum status
        int priority
        date scheduled_date
        date completed_date
        decimal estimated_cost
        decimal actual_cost
        text notes
    }
```

---

## 8. MÓDULO: FACTURACIÓN Y PAGOS

```mermaid
erDiagram
    invoices }o--|| clinics : "de"
    invoices }o--|| patients : "para"
    invoices }o--|| users : "creada_por"
    invoices ||--o{ invoice_items : "contiene"
    invoice_items }o--o| treatments : "factura"
    invoice_items }o--o| products : "factura"
    payments }o--|| clinics : "en"
    payments }o--|| patients : "de"
    payments }o--o| invoices : "aplica_a"
    payments }o--|| payment_methods : "mediante"
    payments }o--|| users : "recibido_por"
    payment_plans }o--|| clinics : "de"
    payment_plans }o--|| patients : "para"
    payment_plans }o--o| quotes : "basado_en"
    payment_plans }o--o| invoices : "para_pagar"
    payment_plans ||--o{ payment_plan_installments : "tiene"
    payment_plan_installments }o--o| payments : "pagada_con"
    clinics ||--o{ payment_methods : "acepta"

    invoices {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        enum invoice_type
        varchar invoice_number UK
        varchar series
        varchar folio
        date invoice_date
        date due_date
        enum status
        decimal subtotal
        decimal discount_amount
        decimal tax_amount
        decimal total
        decimal amount_paid
        decimal balance
        varchar currency
        decimal exchange_rate
        varchar electronic_invoice_uuid
        text electronic_invoice_xml
        varchar electronic_invoice_pdf_path
        timestamp stamped_at
        timestamp cancelled_at
        bigint created_by FK
    }

    invoice_items {
        bigint id PK
        bigint invoice_id FK
        bigint treatment_id FK
        bigint product_id FK
        text description
        decimal quantity
        decimal unit_price
        decimal discount_percentage
        decimal discount_amount
        decimal tax_percentage
        decimal tax_amount
        decimal subtotal
        decimal total
        int sort_order
    }

    payments {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        bigint invoice_id FK
        bigint payment_method_id FK
        varchar payment_number UK
        date payment_date
        decimal amount
        varchar currency
        decimal exchange_rate
        varchar reference_number
        text notes
        enum status
        timestamp cancelled_at
        bigint received_by FK
    }

    payment_methods {
        bigint id PK
        bigint clinic_id FK
        varchar name
        enum type
        boolean requires_reference
        boolean is_active
        int sort_order
    }

    payment_plans {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        bigint quote_id FK
        bigint invoice_id FK
        varchar plan_number UK
        varchar plan_name
        decimal total_amount
        decimal down_payment
        decimal financed_amount
        decimal interest_rate
        int number_of_installments
        enum installment_frequency
        date start_date
        date end_date
        enum status
        decimal late_payment_fee
        text notes
    }

    payment_plan_installments {
        bigint id PK
        bigint payment_plan_id FK
        int installment_number
        date due_date
        decimal principal_amount
        decimal interest_amount
        decimal total_amount
        decimal amount_paid
        decimal balance
        enum status
        date paid_date
        bigint payment_id FK
        decimal late_fee
        text notes
    }
```

---

## 9. MÓDULO: CONTROL FINANCIERO

```mermaid
erDiagram
    clinics ||--o{ income_categories : "tiene"
    clinics ||--o{ incomes : "registra"
    clinics ||--o{ expense_categories : "tiene"
    clinics ||--o{ expenses : "registra"
    clinics ||--o{ cash_registers : "tiene"
    clinics ||--o{ bank_reconciliations : "realiza"
    income_categories ||--o{ incomes : "clasifica"
    expense_categories ||--o{ expense_categories : "padre_de"
    expense_categories ||--o{ expenses : "clasifica"
    payments ||--o{ incomes : "genera"
    suppliers ||--o{ expenses : "proveedor_de"
    purchase_orders ||--o{ expenses : "origina"
    payment_methods ||--o{ expenses : "pago_con"
    users ||--o{ incomes : "registra"
    users ||--o{ expenses : "registra"
    users ||--o{ expenses : "aprueba"
    users ||--o{ bank_reconciliations : "concilia"
    cash_registers ||--o{ cash_register_movements : "tiene"
    cash_register_movements }o--o| payments : "ingreso_de"
    cash_register_movements }o--o| expenses : "egreso_de"
    users ||--o{ cash_register_movements : "opera"

    income_categories {
        bigint id PK
        bigint clinic_id FK
        varchar name
        text description
        boolean is_active
    }

    incomes {
        bigint id PK
        bigint clinic_id FK
        bigint income_category_id FK
        bigint payment_id FK
        date income_date
        decimal amount
        text description
        varchar reference
        text notes
        bigint created_by FK
    }

    expense_categories {
        bigint id PK
        bigint clinic_id FK
        bigint parent_id FK
        varchar name
        enum type
        text description
        boolean is_active
    }

    expenses {
        bigint id PK
        bigint clinic_id FK
        bigint expense_category_id FK
        bigint supplier_id FK
        bigint purchase_order_id FK
        varchar expense_number UK
        date expense_date
        decimal amount
        decimal tax_amount
        decimal total_amount
        bigint payment_method_id FK
        text description
        varchar invoice_number
        varchar reference
        enum status
        text notes
        bigint approved_by FK
        bigint created_by FK
    }

    cash_registers {
        bigint id PK
        bigint clinic_id FK
        varchar register_number
        varchar name
        varchar location
        boolean is_active
    }

    cash_register_movements {
        bigint id PK
        bigint cash_register_id FK
        enum movement_type
        decimal amount
        decimal balance_before
        decimal balance_after
        bigint payment_id FK
        bigint expense_id FK
        text description
        varchar reference
        bigint operated_by FK
        timestamp operated_at
        text notes
    }

    bank_reconciliations {
        bigint id PK
        bigint clinic_id FK
        varchar bank_account
        date reconciliation_date
        decimal statement_balance
        decimal book_balance
        decimal difference
        enum status
        text notes
        bigint reconciled_by FK
        timestamp reconciled_at
    }
```

---

## 10. MÓDULO: INVENTARIO Y COMPRAS

```mermaid
erDiagram
    clinics ||--o{ product_categories : "tiene"
    product_categories ||--o{ product_categories : "padre_de"
    product_categories ||--o{ products : "contiene"
    clinics ||--o{ products : "gestiona"
    clinics ||--o{ warehouses : "tiene"
    clinics ||--o{ suppliers : "trabaja_con"
    clinics ||--o{ purchase_orders : "realiza"
    suppliers ||--o{ purchase_orders : "recibe"
    warehouses ||--o{ purchase_orders : "destino"
    warehouses ||--o{ inventory_movements : "en"
    products ||--o{ inventory_movements : "mueve"
    purchase_orders ||--o{ purchase_order_items : "contiene"
    products ||--o{ purchase_order_items : "compra"
    users ||--o{ purchase_orders : "recibe_mercancia"
    users ||--o{ purchase_orders : "crea"
    users ||--o{ inventory_movements : "realiza"
    cities ||--o{ suppliers : "ubicado_en"

    product_categories {
        bigint id PK
        bigint clinic_id FK
        bigint parent_id FK
        varchar name
        text description
        boolean is_active
    }

    products {
        bigint id PK
        bigint clinic_id FK
        bigint category_id FK
        varchar sku UK
        varchar barcode
        varchar name
        text description
        enum product_type
        varchar unit_of_measure
        decimal cost_price
        decimal selling_price
        decimal minimum_stock
        decimal maximum_stock
        decimal reorder_point
        decimal current_stock
        boolean requires_batch_tracking
        boolean requires_expiry_tracking
        boolean is_active
        varchar image_url
        text notes
    }

    warehouses {
        bigint id PK
        bigint clinic_id FK
        varchar name
        varchar location
        boolean is_active
    }

    inventory_movements {
        bigint id PK
        bigint warehouse_id FK
        bigint product_id FK
        enum movement_type
        decimal quantity
        decimal unit_cost
        decimal total_cost
        varchar batch_number
        date expiry_date
        decimal stock_before
        decimal stock_after
        varchar reference_type
        bigint reference_id
        text reason
        bigint performed_by FK
        timestamp performed_at
    }

    suppliers {
        bigint id PK
        bigint clinic_id FK
        varchar supplier_number UK
        varchar company_name
        varchar contact_name
        varchar email
        varchar phone
        varchar mobile
        text address
        bigint city_id FK
        varchar tax_id
        varchar payment_terms
        decimal credit_limit
        int delivery_time_days
        decimal rating
        boolean is_active
        text notes
    }

    purchase_orders {
        bigint id PK
        bigint clinic_id FK
        bigint supplier_id FK
        bigint warehouse_id FK
        varchar order_number UK
        date order_date
        date expected_delivery_date
        date actual_delivery_date
        enum status
        decimal subtotal
        decimal tax_amount
        decimal shipping_cost
        decimal total
        varchar payment_terms
        text notes
        bigint received_by FK
        bigint created_by FK
    }

    purchase_order_items {
        bigint id PK
        bigint purchase_order_id FK
        bigint product_id FK
        decimal quantity_ordered
        decimal quantity_received
        decimal unit_price
        decimal tax_percentage
        decimal tax_amount
        decimal subtotal
        decimal total
        varchar batch_number
        date expiry_date
        text notes
    }
```

---

## 11. MÓDULO: LABORATORIO DENTAL

```mermaid
erDiagram
    clinics ||--o{ dental_labs : "trabaja_con"
    clinics ||--o{ prosthetic_types : "ofrece"
    clinics ||--o{ lab_orders : "solicita"
    patients ||--o{ lab_orders : "para"
    users ||--o{ lab_orders : "doctor"
    dental_labs ||--o{ lab_orders : "procesa"
    prosthetic_types ||--o{ lab_orders : "tipo"
    lab_orders ||--o{ lab_order_photos : "tiene"
    lab_orders ||--o{ lab_evaluations : "evaluado_en"
    dental_labs ||--o{ lab_evaluations : "evaluado"
    users ||--o{ lab_evaluations : "evalua"
    cities ||--o{ dental_labs : "ubicado_en"

    dental_labs {
        bigint id PK
        bigint clinic_id FK
        varchar lab_number UK
        varchar name
        varchar contact_name
        varchar email
        varchar phone
        varchar mobile
        text address
        bigint city_id FK
        text specialties
        int average_delivery_time_days
        decimal quality_rating
        varchar payment_terms
        boolean is_active
        text notes
    }

    prosthetic_types {
        bigint id PK
        bigint clinic_id FK
        varchar name
        enum category
        text description
        decimal default_cost
        int default_delivery_days
        boolean is_active
    }

    lab_orders {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        bigint doctor_id FK
        bigint dental_lab_id FK
        bigint prosthetic_type_id FK
        varchar order_number UK
        date order_date
        date impression_date
        date expected_delivery_date
        date actual_delivery_date
        date try_in_date
        date installation_date
        enum status
        text teeth_numbers
        varchar shade
        varchar material
        text specifications
        decimal cost
        text rejection_reason
        text notes
    }

    lab_order_photos {
        bigint id PK
        bigint lab_order_id FK
        enum photo_type
        varchar file_path
        varchar thumbnail_path
        text description
        timestamp taken_at
    }

    lab_evaluations {
        bigint id PK
        bigint lab_order_id FK
        bigint dental_lab_id FK
        decimal quality_rating
        decimal delivery_time_rating
        decimal communication_rating
        decimal overall_rating
        text comments
        bigint evaluated_by FK
        timestamp evaluated_at
    }
```

---

## 12. MÓDULO: COMUNICACIÓN Y AUDITORÍA

```mermaid
erDiagram
    users ||--o{ audit_logs : "realiza"
    clinics ||--o{ audit_logs : "en"
    users ||--o{ notifications : "recibe"
    clinics ||--o{ whatsapp_messages : "envia"
    patients ||--o{ whatsapp_messages : "recibe"
    clinics ||--o{ email_messages : "envia"
    patients ||--o{ email_messages : "recibe"
    clinics ||--o{ sms_messages : "envia"
    patients ||--o{ sms_messages : "recibe"

    audit_logs {
        bigint id PK
        bigint user_id FK
        bigint clinic_id FK
        varchar action
        varchar entity_type
        bigint entity_id
        json old_values
        json new_values
        varchar ip_address
        text user_agent
        timestamp created_at
    }

    system_logs {
        bigint id PK
        enum level
        text message
        json context
        varchar source
        text stack_trace
        timestamp created_at
    }

    notifications {
        bigint id PK
        bigint user_id FK
        varchar type
        varchar title
        text message
        json data
        boolean is_read
        timestamp read_at
        timestamp created_at
    }

    whatsapp_messages {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        varchar phone_number
        enum message_type
        text message
        varchar template_name
        enum status
        varchar external_id
        text error_message
        timestamp sent_at
        timestamp delivered_at
        timestamp read_at
        text response
    }

    email_messages {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        varchar email_to
        text email_cc
        text email_bcc
        varchar subject
        text body
        boolean is_html
        json attachments
        enum status
        text error_message
        timestamp sent_at
        timestamp opened_at
    }

    sms_messages {
        bigint id PK
        bigint clinic_id FK
        bigint patient_id FK
        varchar phone_number
        text message
        enum status
        varchar external_id
        text error_message
        timestamp sent_at
        timestamp delivered_at
    }
```

---

## Resumen de Cardinalidades

### Relaciones Principales

- **One-to-Many (1:N)**: La mayoría de las relaciones
  - Una clínica tiene muchos usuarios
  - Un paciente tiene muchas citas
  - Un odontograma contiene muchos dientes
  - Un presupuesto contiene muchos ítems

- **Many-to-Many (N:M)**: A través de tablas intermedias
  - Roles y Permisos (role_permissions)
  - Usuarios y Roles (user_roles)
  - Tratamientos y Materiales (treatment_materials)

- **One-to-One (1:1)**:
  - Paciente y Historia Clínica (medical_histories)

### Índices Importantes

Todas las tablas incluyen:
- ✅ Primary Key (id)
- ✅ Foreign Keys indexadas
- ✅ Campos de búsqueda indexados (name, email, code, etc.)
- ✅ Campos de filtrado indexados (status, is_active, type, etc.)
- ✅ Campos de fecha indexados (created_at, appointment_date, etc.)

### Estrategias de Optimización

1. **Soft Deletes**: Uso de `deleted_at` en lugar de eliminar físicamente
2. **Timestamps**: `created_at` y `updated_at` en todas las tablas principales
3. **JSON Fields**: Para datos flexibles (settings, preferences, measurements)
4. **ENUM Types**: Para campos con valores predefinidos (status, type, etc.)
5. **Decimal Precision**: Para valores monetarios y mediciones precisas

---

*Diagramas ERD generados para INNOVADENT v1.0*
*Última actualización: 2025*
