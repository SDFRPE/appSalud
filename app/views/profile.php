
<?php
// Helper function para manejar valores nulos
function safe($array, $key) {
    return isset($array[$key]) && $array[$key] !== null ? htmlspecialchars($array[$key]) : '';
}

// Helper function para manejar el select de sexo
function selected($userData, $value) {
    return isset($userData['sexo']) && $userData['sexo'] === $value ? 'selected' : '';
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('/images/Fondo_Dashboard.png');
            background-size: cover;

            color: white;
            text-align: center;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            position: relative;
        }
        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none;
        }
        .profile-button:hover {
            background: #682773;
        }
        .profile-button:focus, .profile-button:active {
            background: #682773;
            box-shadow: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8;
        }
        .form-control[readonly] {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .labels {
            font-size: 11px;
        }
        #successMessage {
            background: rgba(136, 176, 75, 0.8);
            color: white;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 50%;
            max-width: 400px;
            text-align: center;
            display: none;
        }
        h1 {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }
        i {
            color: #9ABC66;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }
        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
    </style>
</head>
<?php include_once __DIR__ . '/../views/templates/header.php'; ?>
<body>

<!-- Bloque de mensaje de éxito -->
<?php if (isset($successMessage)): ?>
    <div id="successMessage" class="alert alert-success">
        <div class="card">
            <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                <i class="checkmark">✓</i>
            </div>
            <h1>¡Éxito!</h1>
            <p>Los datos se actualizaron satisfactoriamente.</p>
        </div>
    </div>
    <script>
        window.onload = function() {
            const successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 500 );
            }, 2000);
        }
    </script>
<?php endif; ?>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <!-- Columna de perfil -->
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span class="font-weight-bold"><?php echo safe($userData, 'nombres') . ' ' . safe($userData, 'apellidos'); ?></span>
                <span class="text-black-50"><?php echo safe($userData, 'email'); ?></span>
            </div>
        </div>

        <!-- Columna de configuración de perfil -->
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Configuración de Perfil</h4>
                </div>
                <form id="profileForm" method="POST" action="<?php echo BASE_URL; ?>/profile">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo safe($userData, 'dni'); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo safe($userData, 'telefono'); ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">Nombre</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo safe($userData, 'nombres'); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo safe($userData, 'apellidos'); ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo safe($userData, 'email'); ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="labels">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento" value="<?php echo safe($userData, 'departamento'); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Provincia</label>
                            <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo safe($userData, 'provincia'); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo safe($userData, 'ciudad'); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Distrito</label>
                            <input type="text" class="form-control" id="distrito" name="distrito" value="<?php echo safe($userData, 'distrito'); ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo safe($userData, 'direccion'); ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="labels">Sexo</label>
                            <select class="form-select" id="sexo" name="sexo" disabled>
                                <option value="M" <?php echo selected($userData, 'M'); ?>>Masculino</option>
                                <option value="F" <?php echo selected($userData, 'F'); ?>>Femenino</option>
                                <option value="O" <?php echo selected($userData, 'O'); ?>>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="labels">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                   value="<?php echo safe($userData, 'fecha_nacimiento'); ?>" readonly>
                        </div>
                    </div>
                    <div id="editButtons" class="d-flex mt-4">
                        <button type="button" class="btn btn-primary profile-button" id="editButton">Editar</button>
                        <button type="button" class="btn btn-secondary ms-2" id="cancelButton" style="display:none;">Cancelar</button>
                        <button type="submit" class="btn btn-success ms-2" id="saveButton" style="display:none;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nueva columna para "Administración de seres queridos" -->
        <div class="col-md-4">
            <div class="p-3 py-5">
                <h4 class="text-center">Administración de seres queridos</h4>
                <p>Administra y gestiona la información y recursos relacionados tus seres queridos de manera eficiente.</p>

                <!-- Mostrar lista de seres queridos -->
                <table class="table">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    if (is_array($seresQueridos) || is_object($seresQueridos)) {
                        foreach ($seresQueridos as $ser) {
                            echo "<tr>";
                            echo "<td>{$i}</td>";
                            echo "<td>{$ser['dni']}</td>";
                            echo "<td>{$ser['nombres']}</td>";
                            echo "<td>";
                            // Verificar si ya tiene un dispositivo enlazado
                            if (!empty($ser['dispositivo_id'])) {
                                echo "<button type='button' class='btn btn-secondary' disabled title='Ya tiene un dispositivo enlazado'>
                        Dispositivo Enlazado
                      </button>";
                            } else {
                                echo "<button type='button' class='btn btn-success linkDeviceBtn' 
                        data-bs-toggle='modal' 
                        data-bs-target='#linkDeviceModal' 
                        data-adulto-id='{$ser['id']}'>
                        Enlazar Dispositivo
                      </button>";
                            }
                            echo "</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay seres queridos registrados.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>

                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Enlazar Dispositivo -->
<div class="modal fade" id="linkDeviceModal" tabindex="-1" aria-labelledby="linkDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="linkDeviceModalLabel">Enlazar Dispositivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="linkDeviceForm" method="POST" action="<?php echo BASE_URL; ?>/add-device">
                    <input type="hidden" id="adulto_id" name="adulto_id">
                    <div class="mb-3">
                        <label for="dispositivo_id" class="form-label">ID del Dispositivo</label>
                        <input type="text" class="form-control form-control-lg" id="dispositivo_id"
                               name="dispositivo_id" pattern="SUSAL-[A-Z0-9]{5}-[A-Z0-9]{5}-[A-Z0-9]{5}-[A-Z0-9]{5}"
                               placeholder="Ejemplo: SUSAL-X4K9Y-HM2PQ-8TGBV-NPRC7" required>
                    </div>
                    <div class="mb-3">
                        <label for="alias" class="form-label">Alias</label>
                        <input type="text" class="form-control form-control-lg" id="alias"
                               name="alias" placeholder="Ejemplo: Dispositivo Principal" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enlazar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script simplificado para manejar el modal de enlazar dispositivo
    document.addEventListener('DOMContentLoaded', function() {
        // Actualizar el ID del adulto mayor cuando se abre el modal
        const linkBtns = document.querySelectorAll('.linkDeviceBtn');
        linkBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('adulto_id').value = this.dataset.adultoId;
            });
        });

        // Manejar el envío del formulario
        document.getElementById('linkDeviceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Dispositivo enlazado correctamente'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Error al enlazar el dispositivo'
                        });
                    }
                });
        });
    });
</script>

<!-- Modal de Agregar Adulto Mayor -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: rgba(255, 255, 255, 0.8); border-radius: 10px;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
                <h5 class="modal-title" id="addModalLabel">Registrar Adulto Mayor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdultForm" method="POST" action="<?php echo BASE_URL; ?>/add-adult">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni"
                                   placeholder="Ingrese DNI" required pattern="^\d{8}$"
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres"
                                   placeholder="Ingrese nombres" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos"
                                   placeholder="Ingrese apellidos" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Ingrese email" value="<?php echo safe($userData, 'email'); ?>" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                   placeholder="Ingrese teléfono" value="<?php echo safe($userData, 'telefono'); ?>" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento"
                                   placeholder="Ingrese departamento" value="<?php echo safe($userData, 'departamento'); ?>" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="provincia" class="form-label">Provincia</label>
                            <input type="text" class="form-control" id="provincia" name="provincia"
                                   placeholder="Ingrese provincia" value="<?php echo safe($userData, 'provincia'); ?>" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                        <div class="col-md-6">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad"
                                   placeholder="Ingrese ciudad" value="<?php echo safe($userData, 'ciudad'); ?>" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                               placeholder="Ingrese dirección" value="<?php echo safe($userData, 'direccion'); ?>" required
                               style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                    </div>
                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="sexo" name="sexo" required
                                style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                            <option value="" selected disabled>Seleccione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estatura" class="form-label">Estatura</label>
                            <input type="text" class="form-control" id="estatura" name="estatura"
                                   placeholder="Ingrese estatura (cm)" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha sde Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required
                                   style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_de_sangre" class="form-label">Tipo de Sangre</label>
                        <input type="text" class="form-control" id="tipo_de_sangre" name="tipo_de_sangre"
                               placeholder="Ingrese tipo de sangre" required
                               style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);">
                    </div>
                    <div class="mb-3">
                        <label for="padecimientos" class="form-label">Padecimientos</label>
                        <textarea class="form-control" id="padecimientos" name="padecimientos"
                                  placeholder="Ingrese padecimientos" rows="3" required
                                  style="background-color: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.2);"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<!-- Script de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const editButton = document.getElementById('editButton');
    const cancelButton = document.getElementById('cancelButton');
    const saveButton = document.getElementById('saveButton');
    const profileForm = document.getElementById('profileForm');

    let initialValues = {};
    Array.from(profileForm.elements).forEach(element => {
        if (element.id !== 'dni' && element.id !== 'sexo') {
            initialValues[element.id] = element.value;
        }
    });

    editButton.addEventListener('click', () => {
        Array.from(profileForm.elements).forEach(element => {
            if (element.id !== 'dni' && element.id !== 'sexo') {
                element.readOnly = false;
                element.classList.remove('bg-light');
            }
        });
        document.getElementById('sexo').disabled = false;
        editButton.style.display = 'none';
        cancelButton.style.display = 'inline-block';
        saveButton.style.display = 'inline-block';
    });

    cancelButton.addEventListener('click', () => {
        Array.from(profileForm.elements).forEach(element => {
            if (element.id !== 'dni') {
                element.readOnly = true;
                element.classList.add('bg-light');
                if (initialValues[element.id] !== undefined) {
                    element.value = initialValues[element.id];
                }
            }
        });
        document.getElementById('sexo').disabled = true;
        document.getElementById('editButton').style.display = 'block';
        document.getElementById('cancelButton').style.display = 'none';
        document.getElementById('saveButton').style.display = 'none';
    });

    cancelButton.addEventListener('mouseover', () => {
        cancelButton.classList.remove('btn-secondary');
        cancelButton.classList.add('btn-outline-secondary');
    });

    cancelButton.addEventListener('mouseout', () => {
        cancelButton.classList.remove('btn-outline-secondary');
        cancelButton.classList.add('btn-secondary');
    });

    profileForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Remover readonly y disabled antes de enviar
        Array.from(profileForm.elements).forEach(element => {
            element.removeAttribute('readonly');
            element.removeAttribute('disabled');
        });

        // Enviar el formulario
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
            .then(response => response.text())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: 'Los datos se han actualizado exitosamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al actualizar los datos.',
                    confirmButtonText: 'Aceptar'
                });
            });
    });
</script>
</body>
</html>