<?php require_once APP_PATH . '/views/layouts/header.php'; ?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-pretitle">
                Gestión
            </div>
            <h2 class="page-title">
                <i class="ti ti-users icon me-2"></i>
                Pacientes
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="<?php echo APP_URL; ?>/patients/import" class="btn btn-outline-primary d-none d-sm-inline-block">
                    <i class="ti ti-file-upload icon"></i>
                    Importar
                </a>
                <a href="<?php echo APP_URL; ?>/patients/create" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="ti ti-user-plus icon"></i>
                    Nuevo Paciente
                </a>
                <a href="<?php echo APP_URL; ?>/patients/create" class="btn btn-primary d-sm-none btn-icon">
                    <i class="ti ti-plus icon"></i>
                </a>
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

    <?php if (isset($error) && $error): ?>
        <div class="alert alert-<?php echo $error['type']; ?> alert-dismissible" role="alert">
            <div class="d-flex">
                <div><i class="ti ti-alert-triangle icon alert-icon"></i></div>
                <div><?php echo $error['message']; ?></div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Pacientes</h3>
            <div class="col-auto ms-auto">
                <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="ti ti-search icon"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Buscar paciente..." id="searchInput">
                </div>
            </div>
        </div>

        <?php if (empty($patients)): ?>
            <div class="card-body">
                <div class="empty">
                    <div class="empty-icon">
                        <i class="ti ti-user-off icon"></i>
                    </div>
                    <p class="empty-title">No hay pacientes registrados</p>
                    <p class="empty-subtitle text-muted">
                        Comienza agregando tu primer paciente para gestionar su información médica
                    </p>
                    <div class="empty-action">
                        <a href="<?php echo APP_URL; ?>/patients/create" class="btn btn-primary">
                            <i class="ti ti-user-plus icon"></i>
                            Registrar Primer Paciente
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>No. Expediente</th>
                            <th>Fecha Nac.</th>
                            <th>Contacto</th>
                            <th>Última Visita</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2" style="background-image: url(https://ui-avatars.com/api/?name=<?php echo urlencode($patient['first_name'] . ' ' . $patient['last_name']); ?>&background=random)"></span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">
                                                <?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?>
                                                <?php if ($patient['second_last_name']): ?>
                                                    <?php echo ' ' . $patient['second_last_name']; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-muted">
                                                <?php
                                                if ($patient['date_of_birth']) {
                                                    $age = date_diff(
                                                        date_create($patient['date_of_birth']),
                                                        date_create('now')
                                                    )->y;
                                                    echo $age . ' años';
                                                    if ($patient['gender']) {
                                                        echo ' • ' . ($patient['gender'] == 'M' ? 'Masculino' : 'Femenino');
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-outline text-blue"><?php echo $patient['patient_number']; ?></span>
                                </td>
                                <td class="text-muted">
                                    <?php
                                    if ($patient['date_of_birth']) {
                                        echo date('d/m/Y', strtotime($patient['date_of_birth']));
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div>
                                        <?php if ($patient['phone'] || $patient['mobile']): ?>
                                            <i class="ti ti-phone icon me-1"></i>
                                            <?php echo $patient['phone'] ?? $patient['mobile']; ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($patient['email']): ?>
                                        <div class="text-muted">
                                            <i class="ti ti-mail icon me-1"></i>
                                            <?php echo $patient['email']; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted">
                                    <?php if ($patient['last_visit_date']): ?>
                                        <i class="ti ti-calendar icon me-1"></i>
                                        <?php echo date('d/m/Y', strtotime($patient['last_visit_date'])); ?>
                                    <?php else: ?>
                                        <span class="text-muted">Sin visitas</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="<?php echo APP_URL; ?>/patients/view/<?php echo $patient['id']; ?>"
                                           class="btn btn-sm btn-icon"
                                           title="Ver Perfil">
                                            <i class="ti ti-eye icon"></i>
                                        </a>
                                        <a href="<?php echo APP_URL; ?>/patients/edit/<?php echo $patient['id']; ?>"
                                           class="btn btn-sm btn-icon"
                                           title="Editar">
                                            <i class="ti ti-edit icon"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-icon dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical icon"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo APP_URL; ?>/appointments/create?patient_id=<?php echo $patient['id']; ?>">
                                                        <i class="ti ti-calendar-plus icon me-2"></i>
                                                        Agendar Cita
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo APP_URL; ?>/patients/history/<?php echo $patient['id']; ?>">
                                                        <i class="ti ti-file-medical icon me-2"></i>
                                                        Historia Clínica
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo APP_URL; ?>/patients/odontogram/<?php echo $patient['id']; ?>">
                                                        <i class="ti ti-dental icon me-2"></i>
                                                        Odontograma
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="<?php echo APP_URL; ?>/patients/delete/<?php echo $patient['id']; ?>"
                                                       onclick="return confirm('¿Está seguro de eliminar este paciente?')">
                                                        <i class="ti ti-trash icon me-2"></i>
                                                        Eliminar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($pagination['last_page'] > 1): ?>
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Mostrando <span><?php echo (($pagination['current_page'] - 1) * $pagination['per_page']) + 1; ?></span>
                        a <span><?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total']); ?></span>
                        de <span><?php echo $pagination['total']; ?></span> pacientes
                    </p>
                    <ul class="pagination m-0 ms-auto">
                        <?php if ($pagination['current_page'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $pagination['current_page'] - 1; ?>" tabindex="-1">
                                    <i class="ti ti-chevron-left icon"></i>
                                    anterior
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                            <?php if ($i == 1 || $i == $pagination['last_page'] || ($i >= $pagination['current_page'] - 2 && $i <= $pagination['current_page'] + 2)): ?>
                                <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php elseif ($i == $pagination['current_page'] - 3 || $i == $pagination['current_page'] + 3): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $pagination['current_page'] + 1; ?>">
                                    siguiente
                                    <i class="ti ti-chevron-right icon"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Simple client-side search
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>
