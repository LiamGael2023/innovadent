<?php require_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-users"></i> Gestión de Pacientes</h2>
        <a href="<?php echo APP_URL; ?>/patients/create" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Nuevo Paciente
        </a>
    </div>

    <?php if (isset($success) && $success): ?>
        <div class="alert alert-<?php echo $success['type']; ?> alert-dismissible fade show">
            <?php echo $success['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($error) && $error): ?>
        <div class="alert alert-<?php echo $error['type']; ?> alert-dismissible fade show">
            <?php echo $error['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0">Lista de Pacientes</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar paciente..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($patients)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-user-slash fa-3x mb-3"></i>
                    <p>No hay pacientes registrados</p>
                    <a href="<?php echo APP_URL; ?>/patients/create" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Registrar Primer Paciente
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Expediente</th>
                                <th>Nombre Completo</th>
                                <th>Fecha Nacimiento</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Última Visita</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patients as $patient): ?>
                                <tr>
                                    <td><strong><?php echo $patient['patient_number']; ?></strong></td>
                                    <td>
                                        <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
                                        <?php if ($patient['second_last_name']): ?>
                                            <?php echo ' ' . $patient['second_last_name']; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($patient['date_of_birth']) {
                                            echo date('d/m/Y', strtotime($patient['date_of_birth']));
                                            $age = date_diff(
                                                date_create($patient['date_of_birth']),
                                                date_create('now')
                                            )->y;
                                            echo ' <span class="text-muted">(' . $age . ' años)</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $patient['phone'] ?? $patient['mobile']; ?></td>
                                    <td><?php echo $patient['email'] ?? '-'; ?></td>
                                    <td>
                                        <?php echo $patient['last_visit_date']
                                            ? date('d/m/Y', strtotime($patient['last_visit_date']))
                                            : '<span class="text-muted">Sin visitas</span>'; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo APP_URL; ?>/patients/view/<?php echo $patient['id']; ?>"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo APP_URL; ?>/patients/edit/<?php echo $patient['id']; ?>"
                                               class="btn btn-sm btn-outline-warning"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo APP_URL; ?>/appointments/create?patient_id=<?php echo $patient['id']; ?>"
                                               class="btn btn-sm btn-outline-success"
                                               title="Agendar Cita">
                                                <i class="fas fa-calendar-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <?php if ($pagination['last_page'] > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                                <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <p class="text-center text-muted">
                        Mostrando página <?php echo $pagination['current_page']; ?> de <?php echo $pagination['last_page']; ?>
                        (Total: <?php echo $pagination['total']; ?> pacientes)
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>
