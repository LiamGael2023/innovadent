<?php require_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-dashboard"></i> Dashboard</h2>
        <div class="text-end">
            <p class="mb-0"><strong><?php echo date('l, d F Y'); ?></strong></p>
            <p class="text-muted mb-0">Bienvenido, <?php echo $user['first_name']; ?>!</p>
        </div>
    </div>

    <?php if (isset($success) && $success): ?>
        <div class="alert alert-<?php echo $success['type']; ?> alert-dismissible fade show">
            <?php echo $success['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Citas de Hoy</p>
                            <h3 class="mb-0"><?php echo count($today_appointments); ?></h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-calendar-check fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Citas del Mes</p>
                            <h3 class="mb-0"><?php echo $month_stats['total_appointments'] ?? 0; ?></h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Pacientes Activos</p>
                            <h3 class="mb-0"><?php echo $total_patients; ?></h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Tasa Completadas</p>
                            <h3 class="mb-0">
                                <?php
                                $rate = $month_stats['total_appointments'] > 0
                                    ? round(($month_stats['completed'] / $month_stats['total_appointments']) * 100)
                                    : 0;
                                echo $rate . '%';
                                ?>
                            </h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-percent fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Citas de Hoy -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-clock"></i> Citas de Hoy</h5>
                    <a href="<?php echo APP_URL; ?>/appointments" class="btn btn-sm btn-primary">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($today_appointments)): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p>No hay citas programadas para hoy</p>
                            <a href="<?php echo APP_URL; ?>/appointments/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Agendar Cita
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Doctor</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($today_appointments as $apt): ?>
                                        <tr>
                                            <td><?php echo date('H:i', strtotime($apt['start_time'])); ?></td>
                                            <td>
                                                <?php echo $apt['patient_first_name'] . ' ' . $apt['patient_last_name']; ?>
                                            </td>
                                            <td>
                                                Dr. <?php echo $apt['doctor_first_name'] . ' ' . $apt['doctor_last_name']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $badges = [
                                                    'scheduled' => 'bg-secondary',
                                                    'confirmed' => 'bg-info',
                                                    'waiting' => 'bg-warning',
                                                    'in_progress' => 'bg-primary',
                                                    'completed' => 'bg-success'
                                                ];
                                                $badge = $badges[$apt['status']] ?? 'bg-secondary';
                                                ?>
                                                <span class="badge <?php echo $badge; ?>">
                                                    <?php echo ucfirst($apt['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo APP_URL; ?>/appointments/view/<?php echo $apt['id']; ?>"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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

        <!-- Accesos Rápidos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo APP_URL; ?>/appointments/create" class="btn btn-outline-primary">
                            <i class="fas fa-calendar-plus"></i> Nueva Cita
                        </a>
                        <a href="<?php echo APP_URL; ?>/patients/create" class="btn btn-outline-success">
                            <i class="fas fa-user-plus"></i> Nuevo Paciente
                        </a>
                        <a href="<?php echo APP_URL; ?>/invoices/create" class="btn btn-outline-info">
                            <i class="fas fa-file-invoice"></i> Nueva Factura
                        </a>
                        <a href="<?php echo APP_URL; ?>/reports" class="btn btn-outline-warning">
                            <i class="fas fa-chart-bar"></i> Ver Reportes
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Estadísticas del Mes</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            Completadas: <strong><?php echo $month_stats['completed'] ?? 0; ?></strong>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-times-circle text-danger"></i>
                            Canceladas: <strong><?php echo $month_stats['cancelled'] ?? 0; ?></strong>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user-times text-warning"></i>
                            No asistieron: <strong><?php echo $month_stats['no_shows'] ?? 0; ?></strong>
                        </li>
                        <li>
                            <i class="fas fa-clock text-info"></i>
                            Pendientes: <strong><?php echo $month_stats['pending'] ?? 0; ?></strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>
