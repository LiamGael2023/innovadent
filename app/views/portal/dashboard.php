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

        .navbar-portal {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .appointment-card {
            border-left: 4px solid #667eea;
            transition: all 0.2s;
        }

        .appointment-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md navbar-portal d-print-none" data-bs-theme="dark">
            <div class="container-xl">
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="<?php echo APP_URL; ?>/portal">
                        <i class="ti ti-dental icon me-2"></i>
                        INNOVADENT
                    </a>
                </h1>

                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name=<?php echo urlencode($patient['first_name'] . ' ' . $patient['last_name']); ?>&background=fff&color=667eea)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?></div>
                                <div class="mt-1 small text-muted">Paciente</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="<?php echo APP_URL; ?>/portal/profile" class="dropdown-item">
                                <i class="ti ti-user icon me-2"></i> Mi Perfil
                            </a>
                            <a href="<?php echo APP_URL; ?>/portal/documents" class="dropdown-item">
                                <i class="ti ti-files icon me-2"></i> Mis Documentos
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo APP_URL; ?>/portal/logout" class="dropdown-item">
                                <i class="ti ti-logout icon me-2"></i> Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <!-- Page header -->
                    <div class="page-header d-print-none mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <div class="page-pretitle">
                                    Bienvenido de nuevo
                                </div>
                                <h2 class="page-title">
                                    <i class="ti ti-home icon me-2"></i>
                                    Portal del Paciente
                                </h2>
                            </div>
                            <div class="col-auto ms-auto d-print-none">
                                <div class="btn-list">
                                    <a href="<?php echo APP_URL; ?>/portal/schedule" class="btn btn-primary">
                                        <i class="ti ti-calendar-plus icon"></i>
                                        Agendar Cita
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-<?php echo $success['type']; ?> alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div><i class="ti ti-check icon alert-icon"></i></div>
                                <div><?php echo $success['message']; ?></div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    <?php endif; ?>

                    <!-- Stats Row -->
                    <div class="row row-deck row-cards mb-4">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Total de Citas</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mt-3">
                                        <div class="h1 mb-0 me-2"><?php echo $stats['total_appointments'] ?? 0; ?></div>
                                        <div class="me-auto">
                                            <span class="text-muted">citas</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Total Pagado</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mt-3">
                                        <div class="h1 mb-0 me-2 text-success">$<?php echo number_format($stats['total_paid'] ?? 0, 2); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Saldo Pendiente</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mt-3">
                                        <div class="h1 mb-0 me-2 text-warning">$<?php echo number_format($stats['total_balance'] ?? 0, 2); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Próximas Citas</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mt-3">
                                        <div class="h1 mb-0 me-2 text-info"><?php echo count($upcoming_appointments); ?></div>
                                        <div class="me-auto">
                                            <span class="text-muted">programadas</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-deck row-cards">
                        <!-- Upcoming Appointments -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-calendar-event icon me-2"></i>
                                        Próximas Citas
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($upcoming_appointments)): ?>
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <i class="ti ti-calendar-off icon"></i>
                                            </div>
                                            <p class="empty-title">No tienes citas programadas</p>
                                            <p class="empty-subtitle text-muted">
                                                Agenda una cita para recibir atención dental
                                            </p>
                                            <div class="empty-action">
                                                <a href="<?php echo APP_URL; ?>/portal/schedule" class="btn btn-primary">
                                                    <i class="ti ti-calendar-plus icon"></i>
                                                    Agendar Cita
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($upcoming_appointments as $apt): ?>
                                                <div class="list-group-item appointment-card">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <span class="avatar" style="background: linear-gradient(135deg, #667eea, #764ba2)">
                                                                <i class="ti ti-calendar icon"></i>
                                                            </span>
                                                        </div>
                                                        <div class="col">
                                                            <div class="text-truncate">
                                                                <strong><?php echo date('d/m/Y', strtotime($apt['appointment_date'])); ?></strong>
                                                            </div>
                                                            <div class="text-muted">
                                                                <i class="ti ti-clock icon"></i>
                                                                <?php echo date('h:i A', strtotime($apt['start_time'])); ?>
                                                            </div>
                                                            <div class="text-muted small">
                                                                <i class="ti ti-user-md icon"></i>
                                                                Dr. <?php echo $apt['doctor_first_name'] . ' ' . $apt['doctor_last_name']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="badge bg-primary">Programada</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Appointments History -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-history icon me-2"></i>
                                        Historial Reciente
                                    </h3>
                                    <div class="card-actions">
                                        <a href="<?php echo APP_URL; ?>/portal/appointments" class="btn btn-sm">
                                            Ver Todo
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($recent_appointments)): ?>
                                        <p class="text-muted text-center">No hay historial de citas</p>
                                    <?php else: ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach (array_slice($recent_appointments, 0, 5) as $apt): ?>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <span class="avatar bg-success-lt">
                                                                <i class="ti ti-check icon"></i>
                                                            </span>
                                                        </div>
                                                        <div class="col">
                                                            <div class="text-truncate">
                                                                <strong><?php echo date('d/m/Y', strtotime($apt['appointment_date'])); ?></strong>
                                                            </div>
                                                            <div class="text-muted small">
                                                                Dr. <?php echo $apt['doctor_first_name'] . ' ' . $apt['doctor_last_name']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="badge bg-success-lt">Completada</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row row-cards mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-bolt icon me-2"></i>
                                        Acciones Rápidas
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <a href="<?php echo APP_URL; ?>/portal/schedule" class="btn btn-outline-primary w-100">
                                                <i class="ti ti-calendar-plus icon"></i>
                                                Agendar Cita
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="<?php echo APP_URL; ?>/portal/appointments" class="btn btn-outline-info w-100">
                                                <i class="ti ti-calendar icon"></i>
                                                Ver Mis Citas
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="<?php echo APP_URL; ?>/portal/documents" class="btn btn-outline-success w-100">
                                                <i class="ti ti-file-medical icon"></i>
                                                Mis Documentos
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="<?php echo APP_URL; ?>/portal/profile" class="btn btn-outline-warning w-100">
                                                <i class="ti ti-user icon"></i>
                                                Mi Perfil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    &copy; <?php echo date('Y'); ?>
                                    <a href="<?php echo APP_URL; ?>" class="link-secondary">INNOVADENT</a>
                                </li>
                                <li class="list-inline-item">
                                    <span class="text-muted">Portal del Paciente</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/js/tabler.min.js"></script>
</body>
</html>
