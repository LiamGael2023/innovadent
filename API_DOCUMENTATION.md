# INNOVADENT API REST - Documentación

## Información General

**Base URL**: `http://tu-dominio/api.php`
**Formato**: JSON
**Autenticación**: Bearer Token

## Autenticación

### Login
Obtener token de autenticación

**Endpoint**: `/api.php?endpoint=auth&action=login`
**Método**: `POST`
**Headers**: `Content-Type: application/json`

**Body**:
```json
{
    "username": "admin",
    "password": "admin123"
}
```

**Respuesta Exitosa** (200):
```json
{
    "success": true,
    "message": "Autenticación exitosa",
    "data": {
        "token": "abc123...",
        "token_type": "Bearer",
        "expires_in": 7200,
        "user": {
            "id": 1,
            "username": "admin",
            "email": "admin@innovadent.com",
            "first_name": "Administrador",
            "last_name": "Sistema",
            "is_doctor": false,
            "clinic_id": 1,
            "roles": [...]
        }
    }
}
```

### Obtener Usuario Actual
**Endpoint**: `/api.php?endpoint=auth`
**Método**: `GET`
**Headers**:
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Respuesta**:
```json
{
    "success": true,
    "data": {
        "user": { ... }
    }
}
```

### Logout
**Endpoint**: `/api.php?endpoint=auth&action=logout`
**Método**: `POST`
**Headers**: `Authorization: Bearer {token}`

---

## Pacientes

### Listar Pacientes
**Endpoint**: `/api.php?endpoint=patients`
**Método**: `GET`
**Headers**: `Authorization: Bearer {token}`

**Query Parameters**:
- `page` (opcional): Número de página (default: 1)
- `per_page` (opcional): Registros por página (default: 20)
- `search` (opcional): Buscar por nombre

**Ejemplo**:
```
GET /api.php?endpoint=patients&page=1&per_page=20
GET /api.php?endpoint=patients&search=Juan
```

**Respuesta**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "patient_number": "PAC000001",
            "first_name": "Juan",
            "last_name": "Pérez",
            "email": "juan@email.com",
            "phone": "555-1234",
            ...
        }
    ],
    "pagination": {
        "total": 100,
        "per_page": 20,
        "current_page": 1,
        "last_page": 5,
        "from": 1,
        "to": 20
    }
}
```

### Obtener Paciente Específico
**Endpoint**: `/api.php?endpoint=patients&id={id}`
**Método**: `GET`
**Headers**: `Authorization: Bearer {token}`

**Respuesta**:
```json
{
    "success": true,
    "data": {
        "patient": { ... },
        "medical_history": { ... },
        "stats": {
            "total_appointments": 15,
            "no_shows": 2,
            "total_paid": 15000.00,
            "total_balance": 2500.00
        }
    }
}
```

### Crear Paciente
**Endpoint**: `/api.php?endpoint=patients`
**Método**: `POST`
**Headers**:
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body**:
```json
{
    "first_name": "María",
    "last_name": "González",
    "second_last_name": "López",
    "date_of_birth": "1990-05-15",
    "gender": "female",
    "blood_type": "O+",
    "email": "maria@email.com",
    "phone": "555-5678",
    "mobile": "555-9012",
    "address": "Calle Principal 123",
    "postal_code": "12345",
    "occupation": "Ingeniera",
    "referred_by": "Dr. Smith",
    "notes": "Paciente nuevo"
}
```

**Respuesta** (201):
```json
{
    "success": true,
    "message": "Paciente creado exitosamente",
    "data": {
        "id": 123,
        "patient_number": "PAC000123",
        ...
    }
}
```

### Actualizar Paciente
**Endpoint**: `/api.php?endpoint=patients&id={id}`
**Método**: `PUT`
**Headers**:
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body**: (campos a actualizar)
```json
{
    "phone": "555-9999",
    "email": "nuevo@email.com"
}
```

### Eliminar Paciente
**Endpoint**: `/api.php?endpoint=patients&id={id}`
**Método**: `DELETE`
**Headers**: `Authorization: Bearer {token}`

---

## Citas

### Listar Citas
**Endpoint**: `/api.php?endpoint=appointments`
**Método**: `GET`
**Headers**: `Authorization: Bearer {token}`

**Query Parameters**:
- `date` (opcional): Fecha (YYYY-MM-DD, default: hoy)
- `doctor_id` (opcional): Filtrar por doctor

**Ejemplo**:
```
GET /api.php?endpoint=appointments&date=2025-01-15
GET /api.php?endpoint=appointments&date=2025-01-15&doctor_id=5
```

**Respuesta**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "patient_id": 10,
            "doctor_id": 5,
            "appointment_date": "2025-01-15",
            "start_time": "10:00:00",
            "end_time": "10:30:00",
            "status": "scheduled",
            "patient_first_name": "Juan",
            "patient_last_name": "Pérez",
            "doctor_first_name": "Ana",
            "doctor_last_name": "García",
            ...
        }
    ],
    "filters": {
        "date": "2025-01-15",
        "doctor_id": 5
    }
}
```

### Obtener Cita Específica
**Endpoint**: `/api.php?endpoint=appointments&id={id}`
**Método**: `GET`

### Crear Cita
**Endpoint**: `/api.php?endpoint=appointments`
**Método**: `POST`

**Body**:
```json
{
    "patient_id": 10,
    "doctor_id": 5,
    "appointment_type_id": 1,
    "appointment_date": "2025-01-20",
    "start_time": "14:00",
    "duration_minutes": 30,
    "reason": "Limpieza dental",
    "notes": "Paciente prefiere anestesia"
}
```

**Respuesta** (201):
```json
{
    "success": true,
    "message": "Cita creada exitosamente",
    "data": { ... }
}
```

### Actualizar Cita / Cambiar Estado
**Endpoint**: `/api.php?endpoint=appointments&id={id}`
**Método**: `PUT`

**Body** (para cambiar estado):
```json
{
    "status": "confirmed"
}
```

**Estados disponibles**:
- `scheduled` - Agendada
- `confirmed` - Confirmada
- `waiting` - En sala de espera
- `in_progress` - En atención
- `completed` - Completada
- `cancelled` - Cancelada
- `no_show` - No asistió

### Cancelar Cita
**Endpoint**: `/api.php?endpoint=appointments&id={id}`
**Método**: `DELETE`

---

## Códigos de Respuesta

| Código | Significado |
|--------|-------------|
| 200 | OK - Solicitud exitosa |
| 201 | Created - Recurso creado |
| 400 | Bad Request - Datos inválidos |
| 401 | Unauthorized - No autenticado |
| 404 | Not Found - Recurso no encontrado |
| 422 | Unprocessable Entity - Validación fallida |
| 500 | Internal Server Error - Error del servidor |

## Errores

Formato de error:
```json
{
    "error": "Tipo de error",
    "message": "Descripción detallada del error"
}
```

## Ejemplos de Uso

### JavaScript (Fetch API)
```javascript
// Login
const login = async () => {
    const response = await fetch('http://localhost/innovadent/api.php?endpoint=auth&action=login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: 'admin',
            password: 'admin123'
        })
    });

    const data = await response.json();
    const token = data.data.token;
    localStorage.setItem('token', token);
};

// Obtener pacientes
const getPatients = async () => {
    const token = localStorage.getItem('token');

    const response = await fetch('http://localhost/innovadent/api.php?endpoint=patients', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    });

    const data = await response.json();
    console.log(data.data);
};
```

### cURL
```bash
# Login
curl -X POST http://localhost/innovadent/api.php?endpoint=auth&action=login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"admin123"}'

# Obtener pacientes (con token)
curl http://localhost/innovadent/api.php?endpoint=patients \
  -H "Authorization: Bearer abc123..."

# Crear paciente
curl -X POST http://localhost/innovadent/api.php?endpoint=patients \
  -H "Authorization: Bearer abc123..." \
  -H "Content-Type: application/json" \
  -d '{"first_name":"Juan","last_name":"Pérez","gender":"male","phone":"555-1234"}'
```

### Python (requests)
```python
import requests

# Login
response = requests.post(
    'http://localhost/innovadent/api.php?endpoint=auth&action=login',
    json={'username': 'admin', 'password': 'admin123'}
)
token = response.json()['data']['token']

# Obtener pacientes
response = requests.get(
    'http://localhost/innovadent/api.php?endpoint=patients',
    headers={'Authorization': f'Bearer {token}'}
)
patients = response.json()['data']
```

## Límites y Cuotas

- **Rate Limiting**: 100 requests por minuto por token
- **Paginación máxima**: 100 registros por página
- **Tamaño máximo de request**: 10MB

## Versionado

Versión actual: **v1.0**

En el futuro se agregará versionado en la URL:
```
/api/v1/patients
/api/v2/patients
```

## Soporte

- Documentación: https://docs.innovadent.com/api
- Email: api@innovadent.com
- GitHub Issues: https://github.com/innovadent/issues

---

**INNOVADENT API v1.0** - © 2025
