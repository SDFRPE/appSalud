<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - AppSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/Fondo_Sutil_Paisaje.jpg'); /* Cambia a tu imagen de fondo */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; /* Eliminar margen por defecto */
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 90%; /* Ancho del contenedor en porcentaje */
            max-width: 400px; /* Ancho máximo */
            height: auto; /* Altura automática */
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Espacio entre los elementos */
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

        .form-control {
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
            background-color: #45a049; /* Color más oscuro al pasar el mouse */
        }

        h2 {
            margin-bottom: 1rem; /* Espacio entre el título y el formulario */
            text-align: center; /* Centrar el texto del título */
        }

        /* Estilos responsivos */
        @media (max-width: 480px) {
            .form-container {
                padding: 1.5rem; /* Menos padding en pantallas pequeñas */
            }
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
    <h2>Registro</h2>
    <form action="/appSalud/register" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" id="dni" name="dni" placeholder="DNI"
                           value="<?php echo isset($dni) ? htmlspecialchars($dni) : ''; ?>"
                           class="form-control <?php echo isset($dni_error) && $dni_error ? 'error-input' : ''; ?>" required>
                    <?php if (isset($dni_error) && $dni_error): ?>
                        <div class="error mt-1"><?php echo $dni_error; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" id="nombres" name="nombres" placeholder="Nombres"
                           value="<?php echo isset($nombres) ? htmlspecialchars($nombres) : ''; ?>"
                           class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos"
                           value="<?php echo isset($apellidos) ? htmlspecialchars($apellidos) : ''; ?>"
                           class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="Correo Electrónico"
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                           class="form-control <?php echo isset($email_error) && $email_error ? 'error-input' : ''; ?>" required>
                    <?php if (isset($email_error) && $email_error): ?>
                        <div class="error mt-1"><?php echo $email_error; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" class="form-control" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="/appSalud/login" class="btn btn-primary">Regresar</a>
        </div>
    </form>
</div>
</body>
</html>