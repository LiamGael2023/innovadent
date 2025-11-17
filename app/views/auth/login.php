<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title ?? 'Login - INNOVADENT'; ?></title>

    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css" rel="stylesheet">
    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --tblr-primary: #0066CC;
            --tblr-primary-rgb: 0, 102, 204;
        }

        body {
            background: linear-gradient(135deg, #0066CC 0%, #00CC66 100%);
        }

        .page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card-md {
            max-width: 28rem;
        }

        .brand-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, #0066CC, #00CC66);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .brand-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .form-control:focus {
            border-color: #0066CC;
            box-shadow: 0 0 0 0.25rem rgba(0, 102, 204, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0066CC, #00CC66);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0052a3, #00a352);
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }
    </style>
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="<?php echo APP_URL; ?>" class="navbar-brand navbar-brand-autodark">
                    <div class="brand-icon">
                        <i class="ti ti-dental"></i>
                    </div>
                </a>
            </div>

            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">INNOVADENT</h2>
                    <p class="text-muted text-center mb-4">Sistema de Gestión Clínica Dental</p>

                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="ti ti-alert-circle icon alert-icon"></i>
                                </div>
                                <div>
                                    <h4 class="alert-title">Error de autenticación</h4>
                                    <div class="text-muted"><?php echo $error['message']; ?></div>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['flash']) && is_array($_SESSION['flash'])): ?>
                        <?php foreach ($_SESSION['flash'] as $key => $flash): ?>
                            <?php if (is_array($flash) && isset($flash['message'])): ?>
                                <div class="alert alert-<?php echo $flash['type'] ?? 'info'; ?> alert-dismissible" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <i class="ti ti-info-circle icon alert-icon"></i>
                                        </div>
                                        <div><?php echo htmlspecialchars($flash['message']); ?></div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['flash']); ?>
                    <?php endif; ?>

                    <form action="<?php echo APP_URL; ?>/auth/authenticate" method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label">Usuario o Email</label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="ti ti-user icon"></i>
                                </span>
                                <input type="text"
                                       name="username"
                                       class="form-control"
                                       placeholder="Ingresa tu usuario"
                                       autocomplete="username"
                                       required
                                       autofocus>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">
                                Contraseña
                                <span class="form-label-description">
                                    <a href="<?php echo APP_URL; ?>/auth/forgot-password">¿Olvidaste tu contraseña?</a>
                                </span>
                            </label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="ti ti-key icon"></i>
                                </span>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Tu contraseña"
                                       autocomplete="current-password"
                                       required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input">
                                <span class="form-check-label">Recordar mi sesión en este dispositivo</span>
                            </label>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-login icon"></i>
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>

                <div class="hr-text">o</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a href="<?php echo APP_URL; ?>/portal" class="btn w-100">
                                <i class="ti ti-user-circle icon"></i>
                                Acceso Pacientes
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demo credentials -->
            <div class="text-center text-white mt-4">
                <small class="text-white-50">
                    <i class="ti ti-info-circle icon"></i>
                    Credenciales de prueba: <strong>admin</strong> / <strong>admin123</strong>
                </small>
            </div>

            <!-- Footer -->
            <div class="text-center text-white mt-5">
                <div class="mb-2">
                    <a href="<?php echo APP_URL; ?>/docs" class="link-light link-underline link-underline-opacity-0 link-underline-opacity-100-hover me-3">
                        <i class="ti ti-book icon"></i> Documentación
                    </a>
                    <a href="<?php echo APP_URL; ?>/support" class="link-light link-underline link-underline-opacity-0 link-underline-opacity-100-hover">
                        <i class="ti ti-help icon"></i> Soporte
                    </a>
                </div>
                <small class="text-white-50">
                    &copy; <?php echo date('Y'); ?> INNOVADENT - Versión <?php echo APP_VERSION ?? '2.0.0'; ?>
                </small>
            </div>
        </div>
    </div>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/js/tabler.min.js"></script>
</body>
</html>
