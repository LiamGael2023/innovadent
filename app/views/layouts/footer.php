                </main>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5 py-3 bg-light border-top">
            <div class="container text-center">
                <p class="text-muted mb-0">
                    &copy; <?php echo date('Y'); ?> INNOVADENT - Sistema de Gestión Dental
                    <span class="ms-3">Versión <?php echo APP_VERSION; ?></span>
                </p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <!-- Custom JS -->
        <script src="<?php echo APP_URL; ?>/js/main.js"></script>

        <script>
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        </script>
    </body>
</html>
