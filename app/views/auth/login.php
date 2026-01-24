<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - AppSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        body {
            background-image: url('/images/Fondo_Sutil_Paisaje.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.7);
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        .error-input {
            border-color: red;
        }

        .input-group {
            position: relative;
        }

        .input-group .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
        }

        .form-control {
            padding-left: 40px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #4CAF50;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4CAF50;
        }

        .text-center a {
            color: #4CAF50;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="form-container">
    <div class="text-center mb-4">
        <img src="/images/Logo_Empresa.png" alt="Logo de la Aplicación"
             class="img-fluid rounded-circle"
             style="max-width: 150px; height: 150px; object-fit: cover;">
    </div>
    <h2 class="text-center mb-4">Iniciar sesión</h2>
    <form action="<?php echo BASE_URL; ?>/login" method="POST">
        <div class="mb-3 input-group">
            <span class="input-icon">
                <img src="/images/Icono_Usuario.png" alt="Icono de usuario" style="width: 20px;">
            </span>
            <input type="text" id="input" name="input" placeholder="Correo o DNI"
                   class="form-control <?php echo !empty($error_message) ? 'error-input' : ''; ?>"
                   value="<?php echo htmlspecialchars($input ?? ''); ?>" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-icon">
                <img src="/images/Icono_Candado.png" alt="Icono de candado"
                     style="width: 20px;">
            </span>
            <input type="password" id="password" name="password" placeholder="Contraseña"
                   class="form-control <?php echo !empty($error_message) ? 'error-input' : ''; ?>" required>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="error text-center mt-2"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <button class="btn btn-primary w-100">Iniciar sesión</button>
        <div class="text-center mt-3">
            <p>
                <a href="<?php echo BASE_URL; ?>/forgot-password" class="text-white">¿Olvidaste tu contraseña?</a>
            </p>
            <p>
                <a href="<?php echo BASE_URL; ?>/register" class="text-white">¿No tienes una cuenta?</a>
            </p>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>