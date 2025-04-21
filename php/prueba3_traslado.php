<?php
require_once 'conexion2.php'; // Conexión PDO a PostgreSQL

// Obtener periodos
$periodos = $pdo->query("SELECT codigo_periodo, nombre_periodo FROM sistema.periodos WHERE estado='ACTIVO' ORDER BY anio DESC, codigo_periodo DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Trasladar Microcurrículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="p-4">
    <div class="container">
        <h3>Traslado de Microcurrículo (m1)</h3>
        <form id="trasladarForm">
            <div class="row mb-3">
                <div class="col">
                    <label>Periodo Origen:</label>
                    <select name="periodo_origen" id="periodo_origen" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($periodos as $p): ?>
                            <option value="<?= $p['codigo_periodo'] ?>"><?= $p['nombre_periodo'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label>Periodo Destino:</label>
                    <select name="periodo_destino" id="periodo_destino" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($periodos as $p): ?>
                            <option value="<?= $p['codigo_periodo'] ?>"><?= $p['nombre_periodo'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Asignatura:</label>
                <select name="codigo_asignatura" id="codigo_asignatura" class="form-select" required>
                    <option value="">Seleccione una asignatura</option>
                </select>
            </div>

            <div class="form-group">
                <label for="codigo_usuario">Código del docente:</label>
                <input type="text" class="form-control" id="codigo_usuario" name="codigo_usuario" required>
            </div>

            <div class="form-group">
                <label for="nombre_docente">Nombre del docente:</label>
                <input type="text" class="form-control" id="nombre_docente" name="nombre_docente" readonly>
            </div>



            <button type="submit" class="btn btn-primary">Trasladar</button>
        </form>
    </div>

    <script>
        document.getElementById("periodo_origen").addEventListener("change", function() {
            const periodo = this.value;
            const selectAsignatura = document.getElementById("codigo_asignatura");
            selectAsignatura.innerHTML = "<option>Cargando...</option>";

            fetch("get_asignaturas3_traslado.php?periodo=" + periodo)
                .then(res => res.json())
                .then(data => {
                    selectAsignatura.innerHTML = '<option value="">Seleccione una asignatura</option>';
                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.codigo_asignatura;
                        option.text = item.codigo_asignatura + " | " + item.nom_asignatura + " - " + " (Grupo " + item.grupo + ")";
                        selectAsignatura.appendChild(option);
                    });
                });
        });
    </script>


    <!--  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script>
        document.getElementById('codigo_usuario').addEventListener('blur', function() {
            const codigo = this.value.trim();
            if (codigo === '') return;

            fetch('buscar_usuario_tm1.php?codigo=' + codigo)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('nombre_docente').value = data.nombre;
                    } else {
                        document.getElementById('nombre_docente').value = '';
                        Swal.fire('No encontrado', 'No se encontró un docente con ese código.', 'warning');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo buscar el nombre del docente.', 'error');
                    console.error(error);
                });
        });

        document.getElementById('trasladarForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este proceso es irreversible. ¿Deseas continuar con el traslado?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, trasladar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(this);

                    fetch('trasladar3_m1.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire(data.title, data.message, data.status);
                            if (data.status === 'success') {
                                // Limpiar el formulario
                                document.getElementById('trasladarForm').reset();

                                // Enfocar en periodo_origen
                                const periodoOrigenInput = document.getElementById('periodo_origen');
                                if (periodoOrigenInput) {
                                    periodoOrigenInput.focus();
                                }
                            }
                        })

                        .catch(err => {
                            console.error(err);
                            Swal.fire('Error', 'Error al conectar con el servidor.', 'error');
                        });
                }
            });
        });
    </script>


</body>

</html>