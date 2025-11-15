<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'INNOVADENT'; ?></title>

    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css" rel="stylesheet">
    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --tblr-primary: #0066CC;
            --tblr-primary-rgb: 0, 102, 204;
            --tblr-secondary: #00CC66;
            --tblr-secondary-rgb: 0, 204, 102;
        }

        .navbar-brand-image {
            height: 2rem;
        }

        .navbar-vertical.navbar-expand-lg {
            background: linear-gradient(180deg, #0066CC 0%, #0052a3 100%);
        }

        .navbar-vertical .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }

        .navbar-vertical .navbar-nav .nav-link:hover,
        .navbar-vertical .navbar-nav .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-vertical .navbar-nav .nav-link .icon {
            color: rgba(255, 255, 255, 0.6);
        }

        .navbar-vertical .navbar-nav .nav-link:hover .icon,
        .navbar-vertical .navbar-nav .nav-link.active .icon {
            color: #fff;
        }

        .navbar-vertical .navbar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.5rem;
            padding: 1rem;
        }

        .page-wrapper {
            background-color: #f4f6fa;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .avatar {
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="page">
        <?php if (isset($_SESSION['user'])): ?>
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <h1 class="navbar-brand">
                    <a href="<?php echo APP_URL; ?>/dashboard">
                        <i class="ti ti-dental"></i> INNOVADENT
                    </a>
                </h1>

                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/dashboard">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-dashboard icon"></i>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/appointments">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-calendar icon"></i>
                                </span>
                                <span class="nav-link-title">Agenda</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/patients">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-users icon"></i>
                                </span>
                                <span class="nav-link-title">Pacientes</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/treatments">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-tooth icon"></i>
                                </span>
                                <span class="nav-link-title">Tratamientos</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/laboratory">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-flask icon"></i>
                                </span>
                                <span class="nav-link-title">Laboratorio</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-file-invoice icon"></i>
                                </span>
                                <span class="nav-link-title">Finanzas</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/invoices">
                                    <i class="ti ti-file-text icon"></i> Facturación
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/payments">
                                    <i class="ti ti-credit-card icon"></i> Pagos
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/quotes">
                                    <i class="ti ti-file-description icon"></i> Presupuestos
                                </a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>/reports">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-chart-bar icon"></i>
                                </span>
                                <span class="nav-link-title">Reportes</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-settings icon"></i>
                                </span>
                                <span class="nav-link-title">Configuración</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/settings">
                                    <i class="ti ti-adjustments icon"></i> Preferencias
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/users">
                                    <i class="ti ti-user-cog icon"></i> Usuarios
                                </a>
                                <a class="dropdown-item" href="<?php echo APP_URL; ?>/clinic">
                                    <i class="ti ti-building icon"></i> Clínica
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']); ?>&background=0066CC&color=fff)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?></div>
                                <div class="mt-1 small text-muted"><?php echo ucfirst($_SESSION['user']['role'] ?? 'Usuario'); ?></div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="<?php echo APP_URL; ?>/profile" class="dropdown-item">
                                <i class="ti ti-user icon me-2"></i> Mi Perfil
                            </a>
                            <a href="<?php echo APP_URL; ?>/settings" class="dropdown-item">
                                <i class="ti ti-settings icon me-2"></i> Configuración
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo APP_URL; ?>/auth/logout" class="dropdown-item">
                                <i class="ti ti-logout icon me-2"></i> Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <?php endif; ?>

            <div class="page-body">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="container-xl">
                <?php endif; ?>
