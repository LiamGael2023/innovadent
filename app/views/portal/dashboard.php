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
            background: #f5f7fa;
        }

        .portal-navbar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 20px 0;
            color: white;
        }

        .portal-sidebar {
            background: white;
            min-height: calc(100vh - 80px);
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .portal-sidebar .nav-link {
            color: #333;
            padding: 12px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .portal-sidebar .nav-link:hover,
        .portal-sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .appointment-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="portal-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0">
                        <i class="fas fa-tooth"></i> Portal del Paciente
                    </h3>
                </div>
                <div>
                    <span class="me-3">
                        <i class="fas fa-user"></i>
                        <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
                    </span>
                    <a href="<?php echo APP_URL; ?>/portal/logout" class="btn btn-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 portal-sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo APP_URL; ?>/portal/dashboard">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/portal/appointments">
                            <i class="fas fa-calendar"></i> Mis Citas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/portal/schedule">
                            <i class="fas fa-calendar-plus"></i> Agendar Cita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/portal/profile">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/portal/documents">
                            <i class="fas fa-file-medical"></i> Documentos
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 px-4">
                <h2 class="mb-4">Bienvenido, <?php echo $patient['first_name']; ?>!</h2>

                <?php if (isset($success) && $success): ?>
                    <div class="alert alert-<?php echo $success['type']; ?> alert-dismissible fade show">
                        <?php echo $success['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Estadísticas -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Citas</h6>
                                    <h3 class="mb-0"><?php echo $stats['total_appointments'] ?? 0; ?></h3>
                                </div>
                                <i class="fas fa-calendar-check fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Pagado</h6>
                                    <h3 class="mb-0">$<?php echo number_format($stats['total_paid'] ?? 0, 2); ?></h3>
                                </div>
                                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Saldo Pendiente</h6>
                                    <h3 class="mb-0">$<?php echo number_format($stats['total_balance'] ?? 0, 2); ?></h3>
                                </div>
                                <i class="fas fa-receipt fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Próximas Citas</h6>
                                    <h3 class="mb-0"><?php echo count($upcoming_appointments); ?></h3>
                                </div>
                                <i class="fas fa-clock fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Próximas Citas -->
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3"><i class="fas fa-calendar-alt"></i> Próximas Citas</h4>
                        <?php if (empty($upcoming_appointments)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No tienes citas programadas</p>
                                <a href="<?php echo APP_URL; ?>/portal/schedule" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Agendar Cita
                                </a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($upcoming_appointments as $apt): ?>
                                <div class="appointment-card">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1">
                                                <?php echo date('d/m/Y', strtotime($apt['appointment_date'])); ?>
                                            </h5>
                                            <p class="mb-1">
                                                <i class="fas fa-clock"></i>
                                                <?php echo date('h:i A', strtotime($apt['start_time'])); ?>
                                            </p>
                                            <p class="mb-0 text-muted">
                                                <i class="fas fa-user-md"></i>
                                                Dr. <?php echo $apt['doctor_first_name'] . ' ' . $apt['doctor_last_name']; ?>
                                            </p>
                                        </div>
                                        <span class="badge bg-primary">Programada</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <h4 class="mb-3"><i class="fas fa-history"></i> Historial Reciente</h4>
                        <?php if (empty($recent_appointments)): ?>
                            <p class="text-muted">No hay historial de citas</p>
                        <?php else: ?>
                            <?php foreach (array_slice($recent_appointments, 0, 5) as $apt): ?>
                                <div class="appointment-card">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">
                                                <?php echo date('d/m/Y', strtotime($apt['appointment_date'])); ?>
                                            </h6>
                                            <p class="mb-0 text-muted small">
                                                Dr. <?php echo $apt['doctor_first_name'] . ' ' . $apt['doctor_last_name']; ?>
                                            </p>
                                        </div>
                                        <span class="badge bg-success">Completada</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</body>
</html>
