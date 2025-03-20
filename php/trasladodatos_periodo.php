<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trasladar Registros por Periodo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Trasladar Registros por Periodo</h1>

        <form id="trasladoForm">
            <div class="mb-3">
                <label for="periodo_anterior" class="form-label">Periodo Anterior</label>
                <select id="periodo_anterior" class="form-select" required></select>
            </div>

            <div class="mb-3">
                <label for="periodo_nuevo" class="form-label">Nuevo Periodo</label>
                <select id="periodo_nuevo" class="form-select" required></select>
            </div>

            <div class="mb-3">
                <label for="tabla" class="form-label">Seleccionar Tabla</label>
                <select id="tabla" class="form-select" required></select>
            </div>

            <button type="submit" class="btn btn-primary">Trasladar Registros</button>
        </form>

        <div id="result" class="mt-3"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript para cargar los periodos y tablas -->
    <script>
        // Cargar periodos y tablas cuando se cargue la página
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_periodos_tablas.php')
                .then(response => response.json())
                .then(data => {
                    const periodoSelectAnterior = document.getElementById('periodo_anterior');
                    const periodoSelectNuevo = document.getElementById('periodo_nuevo');
                    const tablaSelect = document.getElementById('tabla');

                    // Cargar los periodos
                    data.periodos.forEach(periodo => {
                        const option = document.createElement('option');
                        option.value = periodo.codigo_periodo;
                        option.textContent = periodo.nombre_periodo;
                        periodoSelectAnterior.appendChild(option.cloneNode(true));  // Añadir a ambos selects
                        periodoSelectNuevo.appendChild(option);
                        
                    });

                   
                    
                    // Cargar las tablas
                    data.tablas.forEach(tabla => {
                        const option = document.createElement('option');
                        option.value = tabla.nombre_tabla;
                        option.textContent = tabla.descripcion;
                        tablaSelect.appendChild(option);
                    });
                    //alert(nomp);
                });
        });


        const selectElement = document.getElementById('periodo_nuevo');

        // Añadir un event listener para detectar cambios
        selectElement.addEventListener('change', function() {
            // Obtén la opción seleccionada
            const opcionSeleccionada = selectElement.options[selectElement.selectedIndex];

            // Obtén el textContent de la opción seleccionada
            const texto = opcionSeleccionada.textContent;

            
        });


                          

        // Enviar el formulario de traslado
        document.getElementById('trasladoForm').onsubmit = function(event) {
            event.preventDefault();

            const periodo_anterior = document.getElementById('periodo_anterior').value;
            const periodo_nuevo = document.getElementById('periodo_nuevo').value;
            //const nomp = document.getElementById('periodo_nuevo').textContent;
            const tabla = document.getElementById('tabla').value;

            alert(nomp);

            const formData = new FormData();
            formData.append('periodo_anterior', periodo_anterior);
            formData.append('periodo_nuevo', periodo_nuevo);
            formData.append('tabla', tabla);
            formData.append('nomp', nomp);

            fetch('copiar_registros.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                if (data.status === 'success') {
                    resultDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    resultDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        };
    </script>
</body>
</html>
