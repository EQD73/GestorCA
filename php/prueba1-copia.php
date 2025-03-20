<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir CSV a PostgreSQL</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Cargar archivo CSV</h1>
    <form id="csvForm" enctype="multipart/form-data" method="POST" action="upload1.php">
        <div class="mb-3">
            <label for="csvFile" class="form-label">Seleccione un archivo CSV</label>
            <input class="form-control" type="file" id="csvFile" name="csvFile" accept=".csv" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir CSV</button>
    </form>

    <h2 class="mt-5">Vista previa del CSV</h2>
    <table id="csvPreview" class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Codigo</th>
            <th>Nombres</th>
            <th>Apellidos</th>
        </tr>
        </thead>
        <tbody>
        <!-- Aquí se mostrará la vista previa -->
        </tbody>
    </table>
</div>

<!-- JavaScript para previsualizar el archivo CSV -->
<script>
document.getElementById('csvFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const csvData = event.target.result;
            const rows = csvData.split('\n');
            let html = '';
            rows.forEach((row, index) => {
                const cols = row.split(',');
                if (cols.length === 3 && index > 0) {  // Asumiendo que hay 3 columnas
                    html += `<tr><td>${cols[0]}</td><td>${cols[1]}</td><td>${cols[2]}</td></tr>`;
                }
            });
            document.querySelector('#csvPreview tbody').innerHTML = html;
        };
        reader.readAsText(file);
    }
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
