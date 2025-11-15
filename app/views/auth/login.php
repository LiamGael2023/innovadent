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
            background: linear-gradient(135deg, #0066CC 0%, #00CC66 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header i {
            font-size: 60px;
            color: #0066CC;
            margin-bottom: 15px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #0066CC;
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #0066CC, #00CC66);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-tooth"></i>
                <h1>INNOVADENT</h1>
                <p>Sistema de Gestión Dental</p>
            </div>

            <?php if (isset($error) && $error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo APP_URL; ?>/auth/authenticate" method="POST">
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-user"></i> Usuario o Email
                    </label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Contraseña
                    </label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">
                        Recordar sesión
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted mb-0" style="font-size: 12px;">
                    Usuario demo: <strong>admin</strong> / Contraseña: <strong>admin123</strong>
                </p>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-white">
                &copy; <?php echo date('Y'); ?> INNOVADENT - Versión <?php echo APP_VERSION; ?>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
