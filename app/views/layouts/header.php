<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'INNOVADENT'; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/style.css">

    <style>
        :root {
            --primary-color: #0066CC;
            --secondary-color: #00CC66;
            --danger-color: #CC0000;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #fff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f8f9fa;
            border-left-color: var(--primary-color);
            color: var(--primary-color);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 2px solid #f0f0f0;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0052a3;
            border-color: #0052a3;
        }

        .stat-card {
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo APP_URL; ?>/dashboard">
                <i class="fas fa-tooth"></i> INNOVADENT
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>
                                <?php echo $_SESSION['user']['first_name']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/profile"><i class="fas fa-user"></i> Mi Perfil</a></li>
                                <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/settings"><i class="fas fa-cog"></i> Configuración</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/auth/logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Sidebar -->
                <nav class="col-md-2 d-md-block sidebar p-0">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>/dashboard">
                                    <i class="fas fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>/appointments">
                                    <i class="fas fa-calendar-alt"></i> Agenda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>/patients">
                                    <i class="fas fa-users"></i> Pacientes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>/treatments">
                                    <i class="fas fa-teeth"></i> Tratamientos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>/invoices">
                                    <i class="fas fa-file-invoice-dollar"></i> Facturación
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>/reports">
                                    <i class="fas fa-chart-bar"></i> Reportes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>/settings">
                                    <i class="fas fa-cog"></i> Configuración
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main content -->
                <main class="col-md-10 ms-sm-auto px-md-4">
            <?php else: ?>
                <main class="col-12">
            <?php endif; ?>
