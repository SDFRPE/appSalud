<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28a745">

    <!-- Favicons -->
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/images/favicon-192x192.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #2d3436;
            min-height: 100vh;
            padding-top: 76px;
        }

        .navbar {
            background: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #28a745 !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand img {
            height: 35px;
            transition: all 0.3s ease;
        }

        .nav-link {
            color: #2d3436 !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #28a745 !important;
            background-color: #e3f2e7;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #28a745 !important;
            background-color: #e3f2e7;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background-color: #28a745;
            border-radius: 2px;
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            background-color: #e3f2e7;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='%2328a745' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .logout-btn {
            background-color: #e3f2e7;
            color: #28a745 !important;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #28a745;
            color: #ffffff !important;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: #ffffff;
                padding: 1rem;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-top: 1rem;
            }

            .nav-link {
                padding: 0.8rem 1rem !important;
                margin: 0.2rem 0;
            }

            .logout-btn {
                margin-top: 0.5rem;
            }
        }

        @media (min-width: 992px) {
            .navbar-nav {
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/appSalud">
            AppSalud
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '/appSalud' ? 'active' : ''; ?>"
                       href="/appSalud">Inicio</a>
                </li>

                <?php if (isset($_SESSION['nombre']) && isset($_SESSION['dni'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'profile') !== false ? 'active' : ''; ?>"
                           href="/appSalud/profile">Mi Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'staff') !== false ? 'active' : ''; ?>"
                           href="/appSalud/staff">Equipo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" href="<?php echo BASE_URL; ?>/logout">
                            Cerrar sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'login') !== false ? 'active' : ''; ?>"
                           href="/appSalud/login">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Efecto de scroll en navbar
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Cerrar menú al hacer click en un enlace (móvil)
    document.querySelectorAll('.nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                const bsCollapse = bootstrap.Collapse.getInstance(document.getElementById('navbarNav'));
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    });
</script>
</body>
</html>