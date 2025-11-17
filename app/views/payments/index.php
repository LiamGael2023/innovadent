<?php require_once APP_PATH . '/views/layouts/header.php'; ?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">
                <i class="ti ti-credit-card icon me-2"></i>
                Pagos
            </h2>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl d-flex flex-column justify-content-center">
        <div class="empty">
            <div class="empty-img"><img src="https://cdn.jsdelivr.net/gh/tabler/tabler@1.0.0-beta19/dist/img/illustrations/undraw_under_construction_46pa.svg" height="128" alt="">
            </div>
            <p class="empty-title">Módulo en Desarrollo</p>
            <p class="empty-subtitle text-muted">
                El módulo de Pagos está actualmente en construcción. Pronto podrás registrar pagos, generar recibos y llevar el control de ingresos.
            </p>
            <div class="empty-action">
                <a href="<?php echo APP_URL; ?>/dashboard" class="btn btn-primary">
                    <i class="ti ti-arrow-left icon"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>
