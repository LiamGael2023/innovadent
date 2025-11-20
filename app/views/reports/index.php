<?php require_once APP_PATH . '/views/layouts/header.php'; ?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-pretitle">
                Analítica
            </div>
            <h2 class="page-title">
                <i class="ti ti-chart-bar icon me-2"></i>
                Reportes y Estadísticas
            </h2>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="row row-deck row-cards">
        <!-- Reporte de Citas -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-rounded me-3 bg-primary-lt">
                            <i class="ti ti-calendar-stats icon fs-2"></i>
                        </div>
                        <div>
                            <h3 class="card-title mb-0">Citas</h3>
                            <div class="text-muted">Estadísticas de citas</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted">Analiza el desempeño de tus citas, tasas de completado, cancelaciones y más.</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>/reports/appointments" class="btn btn-primary w-100">
                        <i class="ti ti-eye icon"></i>
                        Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Pacientes -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-rounded me-3 bg-success-lt">
                            <i class="ti ti-users icon fs-2"></i>
                        </div>
                        <div>
                            <h3 class="card-title mb-0">Pacientes</h3>
                            <div class="text-muted">Estadísticas de pacientes</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted">Crecimiento de pacientes, datos demográficos y tendencias.</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>/reports/patients" class="btn btn-success w-100">
                        <i class="ti ti-eye icon"></i>
                        Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte Financiero -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-rounded me-3 bg-info-lt">
                            <i class="ti ti-coins icon fs-2"></i>
                        </div>
                        <div>
                            <h3 class="card-title mb-0">Finanzas</h3>
                            <div class="text-muted">Reporte financiero</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted">Ingresos, pagos pendientes, y análisis de rentabilidad.</p>
                    </div>
                    <a href="<?php echo APP_URL; ?>/reports/financial" class="btn btn-info w-100">
                        <i class="ti ti-eye icon"></i>
                        Ver Reporte
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen Rápido -->
    <div class="row row-deck row-cards mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-chart-line icon me-2"></i>
                        Resumen General
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center p-3">
                                <div class="h1 text-primary mb-2">
                                    <i class="ti ti-calendar-check icon"></i>
                                </div>
                                <div class="h3 mb-1">--</div>
                                <div class="text-muted">Citas Este Mes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3">
                                <div class="h1 text-success mb-2">
                                    <i class="ti ti-user-check icon"></i>
                                </div>
                                <div class="h3 mb-1">--</div>
                                <div class="text-muted">Nuevos Pacientes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3">
                                <div class="h1 text-info mb-2">
                                    <i class="ti ti-currency-dollar icon"></i>
                                </div>
                                <div class="h3 mb-1">$--</div>
                                <div class="text-muted">Ingresos del Mes</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3">
                                <div class="h1 text-warning mb-2">
                                    <i class="ti ti-percentage icon"></i>
                                </div>
                                <div class="h3 mb-1">--%</div>
                                <div class="text-muted">Tasa de Completado</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exportar Datos -->
    <div class="row row-deck row-cards mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-file-download icon me-2"></i>
                        Exportar Datos
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Exportar a CSV</h4>
                            <p class="text-muted">Descarga tus datos en formato CSV para análisis externo.</p>
                            <a href="<?php echo APP_URL; ?>/reports/export?type=appointments" class="btn btn-outline-primary me-2">
                                <i class="ti ti-download icon"></i>
                                Citas
                            </a>
                            <a href="<?php echo APP_URL; ?>/reports/export?type=patients" class="btn btn-outline-success">
                                <i class="ti ti-download icon"></i>
                                Pacientes
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h4>Generar Reporte PDF</h4>
                            <p class="text-muted">Crea reportes detallados en formato PDF.</p>
                            <button class="btn btn-outline-danger" disabled>
                                <i class="ti ti-file-type-pdf icon"></i>
                                Próximamente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>
