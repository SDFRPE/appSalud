<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localización de Dispositivo - SuSalud</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('/images/Fondo_Dashboard.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .welcome-card {
            background: #28a745;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-content {
            text-align: center;
            color: white;
        }

        .welcome-content h1 {
            margin: 0 0 0.5rem 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .user-details {
            display: flex;
            justify-content: center;
            gap: 2rem;
            font-size: 1.1rem;
        }

        .select-person {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .form-select {
            border-radius: 10px;
            padding: 12px;
            font-size: 1.1rem;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .card-title {
            color: #2c3e50;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item {
            padding: 0.8rem 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .info-item i {
            color: #28a745;
            width: 20px;
            text-align: center;
        }

        .map-container {
            height: 500px;
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        #map {
            height: 100%;
            width: 100%;
            z-index: 1;
            border-radius: 15px;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-action {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-share {
            background: #4CAF50;
        }

        .btn-directions {
            background: #2196F3;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            color: white;
            opacity: 0.9;
        }

        .leaflet-control-zoom {
            border: none !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
        }

        .leaflet-control-zoom a {
            background-color: white !important;
            color: #333 !important;
        }

        @media (max-width: 768px) {
            .container {
                margin: 15px;
                padding: 1rem;
            }

            .welcome-card {
                padding: 1rem;
            }

            .user-details {
                flex-direction: column;
                gap: 0.5rem;
            }

            .map-container {
                height: 400px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<?php include_once __DIR__ . '/../views/templates/header.php'; ?>
<body>

<div class="container">
    <div class="welcome-card">
        <div class="welcome-content">
            <h1>Bienvenido/a</h1>
            <div class="user-details">
                <span>Nombre: <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                <span>DNI: <?php echo htmlspecialchars($_SESSION['dni']); ?></span>
            </div>
        </div>
    </div>

    <div class="select-person">
        <label class="form-label fw-bold">Seleccionar Persona</label>
        <select class="form-select" id="adulto_mayor" required>
            <option value="">Elige una persona para ver su ubicación</option>
            <?php if (!empty($seresQueridosDis)): ?>
                <?php foreach ($seresQueridosDis as $persona): ?>
                    <option value="<?php echo htmlspecialchars($persona['id_adultoMayor'] ?? ''); ?>"
                            data-dispositivo="<?php echo htmlspecialchars($persona['dispositivo_id'] ?? ''); ?>"
                            data-nombre="<?php echo htmlspecialchars($persona['nombre_adulto'] . ' ' . $persona['apellido_adulto']); ?>">
                        <?php echo htmlspecialchars($persona['nombre_adulto'] . ' ' . $persona['apellido_adulto']); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <div class="device-info-container" style="display: none;">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="info-card">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Información de Ubicación
                    </h3>
                    <div class="info-content">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <span id="device-name">-</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-mountain"></i>
                            <span id="device-altitude">-</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-satellite"></i>
                            <span id="device-satellites">-</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span id="device-timestamp">-</span>
                        </div>

                        <div class="action-buttons">
                            <a id="share-location" href="#" class="btn-action btn-share" target="_blank">
                                <i class="fas fa-share-alt"></i>
                                Compartir
                            </a>
                            <a id="get-directions" href="#" class="btn-action btn-directions" target="_blank">
                                <i class="fas fa-directions"></i>
                                Cómo llegar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div id="map" class="map-container"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let map, marker;
    let currentInterval;
    const deviceInfoContainer = document.querySelector('.device-info-container');
    const UPDATE_INTERVAL = 2000; // Actualizar cada 2 segundos

    document.addEventListener('DOMContentLoaded', function() {
        // Inicialización del mapa
        map = L.map('map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([-12.005108, -77.016033], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Crear marcador con popup
        marker = L.marker([-12.005108, -77.016033], {
            title: 'Ubicación del dispositivo'
        }).addTo(map);

        // Manejador del select
        document.getElementById('adulto_mayor').addEventListener('change', async function() {
            const selectedOption = this.options[this.selectedIndex];
            const dispositivoId = selectedOption.getAttribute('data-dispositivo');
            const nombrePersona = selectedOption.getAttribute('data-nombre');

            // Limpiar intervalo anterior si existe
            if (currentInterval) {
                clearInterval(currentInterval);
                currentInterval = null;
            }

            if (!this.value) {
                deviceInfoContainer.style.display = 'none';
                return;
            }

            if (!dispositivoId) {
                Swal.fire({
                    icon: 'info',
                    title: 'Sin dispositivo',
                    text: `${nombrePersona} no tiene un dispositivo asociado.`
                });
                deviceInfoContainer.style.display = 'none';
                return;
            }

            // Mostrar contenedor y actualizar mapa
            deviceInfoContainer.style.display = 'block';
            map.invalidateSize();

            // Primera carga de datos
            await fetchDeviceData(dispositivoId);

            // Iniciar actualizaciones periódicas
            currentInterval = setInterval(() => fetchDeviceData(dispositivoId), UPDATE_INTERVAL);
        });
    });

    async function fetchDeviceData(dispositivoId) {
        try {
            const timestamp = new Date().getTime();
            const response = await fetch(`/proxy-api/api/susalud/geoData?id=${dispositivoId}&t=${timestamp}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Cache-Control': 'no-cache'
                }
            });

            if (response.status === 404) {
                // No hay datos recientes disponibles
                document.getElementById('device-name').textContent = 'Sin datos recientes';
                document.getElementById('device-altitude').textContent = 'Altitud: N/D';
                document.getElementById('device-satellites').textContent = 'Satélites: N/D';
                document.getElementById('device-timestamp').textContent = 'Última actualización: No disponible';

                Swal.fire({
                    icon: 'info',
                    title: 'Sin datos recientes',
                    text: 'El dispositivo no ha enviado actualizaciones recientemente.',
                    showConfirmButton: true
                });

                // Detener las actualizaciones periódicas
                if (currentInterval) {
                    clearInterval(currentInterval);
                    currentInterval = null;
                }
                return;
            }

            if (!response.ok) throw new Error('Error en la respuesta del servidor');

            const data = await response.json();
            console.log('Datos recibidos:', new Date().toISOString(), data);

            if (data && data.latitud && data.longitud) {
                const newPosition = [data.latitud, data.longitud];

                // Actualizar marcador con animación
                marker.setLatLng(newPosition);
                map.setView(newPosition, 15);

                // Actualizar información
                document.getElementById('device-name').textContent = data.nombre;
                document.getElementById('device-altitude').textContent =
                    `Altitud: ${Number(data.altitud).toFixed(2)} m`;
                document.getElementById('device-satellites').textContent =
                    `Satélites: ${data.satelites}`;

                const fecha = new Date(data.timestamp);
                document.getElementById('device-timestamp').textContent =
                    `Última actualización: ${fecha.toLocaleString('es-PE')}`;

                // Actualizar enlaces
                const shareUrl = `https://www.google.com/maps?q=${data.latitud},${data.longitud}`;
                const directionsUrl = `https://www.google.com/maps/dir/?api=1&destination=${data.latitud},${data.longitud}`;

                document.getElementById('share-location').href = shareUrl;
                document.getElementById('get-directions').href = directionsUrl;

                // Actualizar popup del marcador
                marker.bindPopup(`
                <strong>${data.nombre}</strong><br>
                Altitud: ${Number(data.altitud).toFixed(2)} m<br>
                Última actualización: ${fecha.toLocaleTimeString('es-PE')}
            `).openPopup();
            }

        } catch (error) {
            console.error('Error al obtener datos:', error);
            clearInterval(currentInterval);

            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo actualizar la información del dispositivo.',
                showConfirmButton: true
            });
        }
    }
</script>
</body>
</html>