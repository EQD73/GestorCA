<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico 3D</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Incluyendo Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Incluyendo el plugin 3D de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>
</head>
<body>
    <div class="container mt-5">
        <h3>Avance Semanal con Gráfico en 3D</h3>
        
        <!-- Gráfico de progreso semanal -->
        <canvas id="weeklyProgressChart" width="400" height="200"></canvas>
    </div>

    <script>
        // Datos de las semanas gestionadas y el progreso
        var weeks = [
            { week: 'Semana 1', gestionadas: 5 },
            { week: 'Semana 2', gestionadas: 8 },
            { week: 'Semana 3', gestionadas: 12 },
            { week: 'Semana 4', gestionadas: 7 },
            { week: 'Semana 5', gestionadas: 10 },
        ];

        // Obtener el total de gestiones para calcular los porcentajes
        var totalGestiones = weeks.reduce((acc, w) => acc + w.gestionadas, 0);

        // Calcular los porcentajes de gestiones por semana
        weeks.forEach(function(week) {
            week.porcentaje = ((week.gestionadas / totalGestiones) * 100).toFixed(2);
        });

        // Mostrar progreso usando Chart.js en 3D
        var ctx = document.getElementById('weeklyProgressChart').getContext('2d');
        var weeklyProgressChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: weeks.map(w => w.week), // Nombres de las semanas
                datasets: [{
                    label: 'Gestiones realizadas',
                    data: weeks.map(w => w.gestionadas), // Datos de las semanas
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                // Opciones para activar el efecto 3D
                plugins: {
                    chartJsPlugin3d: {
                        enabled: true, // Activa el modo 3D
                        angleX: 10,    // Ángulo horizontal
                        angleY: 15,    // Ángulo vertical
                        depth: 10,     // Profundidad del gráfico
                        perspective: 300 // Perspectiva del gráfico
                    }
                }
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
