<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title ?? 'Portal del Paciente - INNOVADENT'; ?></title>

    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css" rel="stylesheet">
    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --tblr-primary: #667eea;
            --tblr-primary-rgb: 102, 126, 234;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card-md {
            max-width: 30rem;
        }

        .brand-icon {
            width: 5rem;
            height: 5rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
        }

        .brand-icon i {
            font-size: 3rem;
            color: white;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3, #653a8a);
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .alert-info {
            background-color: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
            color: #667eea;
        }
    </style>
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="<?php echo APP_URL; ?>" class="navbar-brand navbar-brand-autodark">
                    <div class="brand-icon">
                        <i class="ti ti-user-circle"></i>
                    </div>
                </a>
            </div>

            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-2">Portal del Paciente</h2>
                    <p class="text-muted text-center mb-4">Accede a tu información médica y gestiona tus citas</p>

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

                    <form action="<?php echo APP_URL; ?>/portal/authenticate" method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label">Número de Expediente</label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="ti ti-id icon"></i>
                                </span>
                                <input type="text"
                                       name="patient_number"
                                       class="form-control"
                                       placeholder="PAC000001"
                                       required
                                       autofocus>
                            </div>
                            <small class="form-hint">
                                El número que aparece en tus documentos médicos
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="ti ti-calendar icon"></i>
                                </span>
                                <input type="date"
                                       name="date_of_birth"
                                       class="form-control"
                                       required>
                            </div>
                            <small class="form-hint">
                                Usa tu fecha de nacimiento como contraseña
                            </small>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-login icon"></i>
                                Acceder al Portal
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <div class="alert alert-info mb-0" role="alert">
                        <div class="d-flex">
                            <div>
                                <i class="ti ti-info-circle icon alert-icon"></i>
                            </div>
                            <div>
                                <strong>¿No tienes tu número de expediente?</strong>
                                <div class="text-muted mt-1 small">
                                    Comunícate con la clínica al teléfono que aparece en tu última cita o visita.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-white mt-5">
                <div class="mb-2">
                    <a href="<?php echo APP_URL; ?>/auth/login" class="link-light link-underline link-underline-opacity-0 link-underline-opacity-100-hover me-3">
                        <i class="ti ti-arrow-left icon"></i> Acceso Personal Médico
                    </a>
                </div>
                <small class="text-white-50">
                    &copy; <?php echo date('Y'); ?> INNOVADENT - Portal del Paciente
                </small>
            </div>
        </div>
    </div>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/js/tabler.min.js"></script>
</body>
</html>
