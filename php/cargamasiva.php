<?php

include ("conexion3.php");

// Consulta para obtener las tablas
$query = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'sistema'";
// Preparar la consulta
$stmt = $conn->prepare($query);

// Bindear parámetros (en caso de tener)
//$valor = 'algun_valor'; // Cambia 'algun_valor' por el valor que necesites
//$stmt->bindParam(':valor', $valor);

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Verificar si se obtuvieron resultados
if (!$resultados) {
    echo "Error al obtener las tablas";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Seleccionar Tabla</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Cargue Masivo de Información</h1>
        <form id="tablaForm" method="POST" action="procesar_tabla.php">
            <div class="form-group">
                <label for="tabla">Elige una tabla:</label>
                <select class="form-control" id="tabla" name="tabla">
                    <option value="">Seleccione una tabla</option>
                    <option value="1">Usuarios</option>
                    <option value="2">Asignaturas</option>              
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Seleccionar</button>
        </form>
    </div>

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript para manejar la selección -->
    <script>
        document.getElementById('tablaForm').addEventListener('submit', function (event) {
            let select = document.getElementById('tabla');
            if (select.value === '') {
                event.preventDefault();
                alert('Por favor, selecciona una tabla.');
            }
        });
    </script>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn = null;
$stmt = null;

?>
