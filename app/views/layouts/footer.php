                <?php if (isset($_SESSION['user'])): ?>
                    </div> <!-- /container-xl -->
                <?php endif; ?>
            </div> <!-- /page-body -->

            <?php if (isset($_SESSION['user'])): ?>
            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a href="<?php echo APP_URL; ?>/docs" class="link-secondary">
                                        <i class="ti ti-book icon"></i> Documentación
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="<?php echo APP_URL; ?>/support" class="link-secondary">
                                        <i class="ti ti-help icon"></i> Soporte
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    &copy; <?php echo date('Y'); ?>
                                    <a href="<?php echo APP_URL; ?>" class="link-secondary">INNOVADENT</a>
                                </li>
                                <li class="list-inline-item">
                                    <span class="text-muted">Versión <?php echo APP_VERSION ?? '2.0.0'; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <?php endif; ?>
        </div> <!-- /page-wrapper -->
    </div> <!-- /page -->

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/js/tabler.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Active navigation link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

            navLinks.forEach(function(link) {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href.split('/').pop())) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
