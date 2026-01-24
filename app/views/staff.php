<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipo de Trabajo</title>

    <!-- Fuentes modernas -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <style>
        /* Estilos generales */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f0f0, #e2e2e2);
            margin: 0;
            padding: 0;
            color: #333;
            box-sizing: border-box;
        }

        header {
            text-align: center;
            padding: 50px 20px;
            background: linear-gradient(45deg, #4CAF50, #8BC34A);
            color: white;
            border-bottom: 5px solid #388E3C;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 3em;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* Contenedor de los miembros del equipo */
        .team-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            margin: 50px 10%;
            padding: 0 20px;
        }

        /* Estilo de cada miembro del equipo */
        .team-member {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        /* Imagen de los miembros del equipo */
        .team-photo {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #4CAF50;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .team-member:hover .team-photo {
            transform: scale(1.05);
        }

        /* Estilos de texto */
        h3 {
            font-size: 1.6em;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .role {
            font-size: 1.2em;
            font-weight: 500;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        p {
            font-size: 1em;
            line-height: 1.5;
            color: #777;
            margin-bottom: 10px;
            opacity: 0.85;
        }

        /* Estilo del contenedor de texto */
        .team-member .content {
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Responsividad: ajustes para dispositivos pequeños */
        @media (max-width: 768px) {
            .team-container {
                margin: 50px 5%;
            }

            .page-title {
                font-size: 2.2em;
            }

            .team-member {
                width: 100%;
            }

            .team-photo {
                width: 150px;
                height: 150px;
            }
        }

        /* Animaciones adicionales */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .team-member {
            animation: fadeIn 1s ease-out;
        }

    </style>
</head>
<?php include_once __DIR__ . '/../views/templates/header.php'; ?>
<body>

<header>
    <h1 class="page-title">Conoce a Nuestro Equipo</h1>
</header>

<section class="team-container">
    <!-- Miembro 1: Fundador -->
    <div class="team-member">
        <img src="/images/fundador.png" alt="FUNDADOR" class="team-photo">
        <div class="content">
            <h3>Shande Fernandez</h3>
            <p class="role">Fundador</p>
            <p>Shande es el fundador y forma parte del rol en programación. Con una visión clara, dirige el equipo hacia el éxito.</p>
        </div>
    </div>

    <!-- Miembro 2: Desarrollador -->
    <div class="team-member">
        <img src="/images/desarrollador.png" alt="Developer" class="team-photo">
        <div class="content">
            <h3>Juan Portocarrero</h3>
            <p class="role">Desarrollador</p>
            <p>Juan es nuestro experto en programación, encargada de hacer que todo funcione correctamente desde el lado del código.</p>
        </div>
    </div>

    <!-- Miembro 3: Manager -->
    <div class="team-member">
        <img src="/images/mujer.png" alt="Manager" class="team-photo">
        <div class="content">
            <h3>Alexandra Leon</h3>
            <p class="role">Manager</p>
            <p>Alexandra es el responsable de gestionar los proyectos y coordinar a todos los miembros del equipo para cumplir los plazos.</p>
        </div>
    </div>

    <!-- Miembro 4: Manager -->
    <div class="team-member">
        <img src="/images/mujer.png" alt="Manager" class="team-photo">
        <div class="content">
            <h3>Katty Hilasaca</h3>
            <p class="role">Manager</p>
            <p>Alexandra es el responsable de gestionar los proyectos y coordinar a todos los miembros del equipo para cumplir los plazos.</p>
        </div>
    </div>

    <!-- Miembro 5: Manager -->
    <div class="team-member">
        <img src="/images/hombre.png" alt="Manager" class="team-photo">
        <div class="content">
            <h3>Gabriel Calderon</h3>
            <p class="role">Manager</p>
            <p>Gabriel es responsable de la logística y las operaciones, asegurando la ejecución eficiente de las tareas del equipo.</p>
        </div>
    </div>

    <!-- Miembro 6: Diseñadora -->
    <div class="team-member">
        <img src="/images/disenador.png" alt="Designer" class="team-photo">
        <div class="content">
            <h3>Nahin Alexander</h3>
            <p class="role">Diseñador</p>
            <p>Nahin es nuestro diseñador gráfico, encargado de crear la interfaz de usuario y la experiencia visual de nuestros productos.</p>
        </div>
    </div>
</section>
</body>
<?php include_once __DIR__ . '/../views/templates/footer.php'; ?>
</html>

