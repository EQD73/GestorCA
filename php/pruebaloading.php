<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo Loading con Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2>Ejemplo de carga con AJAX</h2>
        <button id="loadData" class="btn btn-primary">Cargar Datos</button>

        <!-- Aquí va el spinner de carga -->
        <div id="loading" class="spinner-border text-primary" role="status" style="display: none;">
            <span class="visually-hidden">Cargando...</span>
        </div>

        <!-- Aquí se mostrarán los resultados -->
        <div id="resultados" class="mt-3"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#loadData').on('click', function() {
                // Mostrar el spinner
                $('#loading').show();

                // Realizar la petición AJAX
                $.ajax({
                    url: 'dataload.php', // El archivo PHP que procesará la solicitud
                    type: 'GET',
                    success: function(data) {
                        // Ocultar el spinner
                        $('#loading').hide();

                        // Mostrar los resultados
                        $('#resultados').html(data);
                    },
                    error: function() {
                        // Si ocurre un error, ocultar el spinner
                        $('#loading').hide();
                        alert('Error al cargar los datos');
                    }
                });
            });
        });
    </script>

</body>

</html>