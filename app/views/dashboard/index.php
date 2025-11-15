<?php require_once APP_PATH . '/views/layouts/header.php'; ?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-pretitle">
                Bienvenido de nuevo
            </div>
            <h2 class="page-title">
                <i class="ti ti-dashboard icon me-2"></i>
                Dashboard
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="text-muted">
                <div class="fw-bold"><?php echo strftime('%A, %d de %B de %Y', time()); ?></div>
                <div class="small">Último acceso: <?php echo date('H:i'); ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
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
                        <div class="subheader">Citas de Hoy</div>
                        <div class="ms-auto lh-1">
                            <div class="dropdown">
                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Últimas 24 horas</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline mt-3">
                        <div class="h1 mb-0 me-2"><?php echo count($today_appointments); ?></div>
                        <div class="me-auto">
                            <span class="text-green d-inline-flex align-items-center lh-1">
                                <i class="ti ti-trending-up icon"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="chart-revenue-bg" class="chart-sm"></div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Citas del Mes</div>
                    </div>
                    <div class="d-flex align-items-baseline mt-3">
                        <div class="h1 mb-0 me-2"><?php echo $month_stats['total_appointments'] ?? 0; ?></div>
                        <div class="me-auto">
                            <span class="badge bg-green-lt">+<?php echo rand(5, 15); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Pacientes Activos</div>
                    </div>
                    <div class="d-flex align-items-baseline mt-3">
                        <div class="h1 mb-0 me-2"><?php echo $total_patients; ?></div>
                        <div class="me-auto">
                            <span class="text-muted">pacientes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Tasa de Completadas</div>
                    </div>
                    <div class="d-flex align-items-baseline mt-3">
                        <div class="h1 mb-0 me-2">
                            <?php
                            $rate = $month_stats['total_appointments'] > 0
                                ? round(($month_stats['completed'] / $month_stats['total_appointments']) * 100)
                                : 0;
                            echo $rate . '%';
                            ?>
                        </div>
                        <div class="me-auto">
                            <span class="badge bg-<?php echo $rate >= 80 ? 'success' : 'warning'; ?>-lt">
                                <?php echo $rate >= 80 ? 'Excelente' : 'Regular'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-deck row-cards">
        <!-- Citas de Hoy -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-clock icon me-2"></i>
                        Citas de Hoy
                    </h3>
                    <div class="card-actions">
                        <a href="<?php echo APP_URL; ?>/appointments" class="btn btn-primary">
                            <i class="ti ti-calendar icon"></i>
                            Ver Agenda
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($today_appointments)): ?>
                        <div class="empty">
                            <div class="empty-icon">
                                <i class="ti ti-calendar-off icon"></i>
                            </div>
                            <p class="empty-title">No hay citas programadas para hoy</p>
                            <p class="empty-subtitle text-muted">
                                Comienza agregando una nueva cita a tu agenda
                            </p>
                            <div class="empty-action">
                                <a href="<?php echo APP_URL; ?>/appointments/create" class="btn btn-primary">
                                    <i class="ti ti-plus icon"></i>
                                    Agendar Nueva Cita
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Doctor</th>
                                        <th>Estado</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($today_appointments as $apt): ?>
                                        <tr>
                                            <td class="text-muted">
                                                <i class="ti ti-clock icon me-1"></i>
                                                <?php echo date('H:i', strtotime($apt['start_time'])); ?>
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <span class="avatar me-2" style="background-image: url(https://ui-avatars.com/api/?name=<?php echo urlencode($apt['patient_first_name'] . ' ' . $apt['patient_last_name']); ?>&background=random)"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium"><?php echo $apt['patient_first_name'] . ' ' . $apt['patient_last_name']; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">
                                                Dr. <?php echo $apt['doctor_first_name'] . ' ' . $apt['doctor_last_name']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statuses = [
                                                    'scheduled' => ['badge' => 'secondary', 'icon' => 'ti-calendar', 'label' => 'Programada'],
                                                    'confirmed' => ['badge' => 'info', 'icon' => 'ti-check', 'label' => 'Confirmada'],
                                                    'waiting' => ['badge' => 'warning', 'icon' => 'ti-clock', 'label' => 'En Espera'],
                                                    'in_progress' => ['badge' => 'primary', 'icon' => 'ti-progress', 'label' => 'En Progreso'],
                                                    'completed' => ['badge' => 'success', 'icon' => 'ti-check-circle', 'label' => 'Completada']
                                                ];
                                                $status = $statuses[$apt['status']] ?? $statuses['scheduled'];
                                                ?>
                                                <span class="badge badge-outline text-<?php echo $status['badge']; ?>">
                                                    <i class="ti <?php echo $status['icon']; ?> icon"></i>
                                                    <?php echo $status['label']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <a href="<?php echo APP_URL; ?>/appointments/view/<?php echo $apt['id']; ?>" class="btn btn-sm btn-icon">
                                                        <i class="ti ti-eye icon"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Accesos Rápidos -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-bolt icon me-2"></i>
                        Accesos Rápidos
                    </h3>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?php echo APP_URL; ?>/appointments/create" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar bg-primary-lt">
                                    <i class="ti ti-calendar-plus icon"></i>
                                </span>
                            </div>
                            <div class="col text-truncate">
                                <div class="text-reset d-block">Nueva Cita</div>
                                <div class="d-block text-muted text-truncate mt-n1">Agendar una nueva cita</div>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo APP_URL; ?>/patients/create" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar bg-success-lt">
                                    <i class="ti ti-user-plus icon"></i>
                                </span>
                            </div>
                            <div class="col text-truncate">
                                <div class="text-reset d-block">Nuevo Paciente</div>
                                <div class="d-block text-muted text-truncate mt-n1">Registrar paciente</div>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo APP_URL; ?>/invoices/create" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar bg-info-lt">
                                    <i class="ti ti-file-invoice icon"></i>
                                </span>
                            </div>
                            <div class="col text-truncate">
                                <div class="text-reset d-block">Nueva Factura</div>
                                <div class="d-block text-muted text-truncate mt-n1">Crear factura</div>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo APP_URL; ?>/reports" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar bg-warning-lt">
                                    <i class="ti ti-chart-bar icon"></i>
                                </span>
                            </div>
                            <div class="col text-truncate">
                                <div class="text-reset d-block">Reportes</div>
                                <div class="d-block text-muted text-truncate mt-n1">Ver estadísticas</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Estadísticas del Mes -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-chart-pie icon me-2"></i>
                        Estadísticas del Mes
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h1 m-0 text-success"><?php echo $month_stats['completed'] ?? 0; ?></div>
                                <div class="text-muted mb-3">Completadas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h1 m-0 text-danger"><?php echo $month_stats['cancelled'] ?? 0; ?></div>
                                <div class="text-muted mb-3">Canceladas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h1 m-0 text-warning"><?php echo $month_stats['no_shows'] ?? 0; ?></div>
                                <div class="text-muted mb-3">No asistieron</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h1 m-0 text-info"><?php echo $month_stats['pending'] ?? 0; ?></div>
                                <div class="text-muted mb-3">Pendientes</div>
                            </div>
                        </div>
                    </div>

                    <div class="progress progress-separated mt-3">
                        <?php
                        $total = $month_stats['total_appointments'] ?? 1;
                        $completedPct = round((($month_stats['completed'] ?? 0) / $total) * 100);
                        $cancelledPct = round((($month_stats['cancelled'] ?? 0) / $total) * 100);
                        $noShowPct = round((($month_stats['no_shows'] ?? 0) / $total) * 100);
                        $pendingPct = 100 - $completedPct - $cancelledPct - $noShowPct;
                        ?>
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $completedPct; ?>%" title="Completadas"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $cancelledPct; ?>%" title="Canceladas"></div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $noShowPct; ?>%" title="No asistieron"></div>
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $pendingPct; ?>%" title="Pendientes"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>
