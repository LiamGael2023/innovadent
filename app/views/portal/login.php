<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .portal-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 50px;
            max-width: 500px;
            width: 100%;
        }

        .portal-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .portal-header i {
            font-size: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .portal-header h1 {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }

        .portal-header p {
            color: #666;
            font-size: 16px;
        }

        .btn-portal {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 14px;
            font-weight: 600;
            transition: transform 0.3s;
        }

        .btn-portal:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .info-box small {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="portal-card">
        <div class="portal-header">
            <i class="fas fa-user-circle"></i>
            <h1>Portal del Paciente</h1>
            <p>Accede a tu información y gestiona tus citas</p>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo APP_URL; ?>/portal/authenticate" method="POST">
            <div class="mb-4">
                <label class="form-label fw-bold">
                    <i class="fas fa-id-card"></i> Número de Expediente
                </label>
                <input type="text"
                       name="patient_number"
                       class="form-control form-control-lg"
                       placeholder="PAC000001"
                       required
                       autofocus>
                <small class="text-muted">El número que aparece en tus documentos</small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">
                    <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                </label>
                <input type="date"
                       name="date_of_birth"
                       class="form-control form-control-lg"
                       required>
                <small class="text-muted">Usa esto como contraseña de acceso</small>
            </div>

            <button type="submit" class="btn btn-primary btn-portal w-100 btn-lg">
                <i class="fas fa-sign-in-alt"></i> Acceder al Portal
            </button>
        </form>

        <div class="info-box">
            <small>
                <i class="fas fa-info-circle"></i>
                <strong>¿No tienes tu número de expediente?</strong><br>
                Comunícate con la clínica al teléfono que aparece en tu última cita o visita.
            </small>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo APP_URL; ?>" class="btn btn-link">
                <i class="fas fa-arrow-left"></i> Volver a inicio
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
