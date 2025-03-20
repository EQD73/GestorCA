<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avance Semanal con Porcentajes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Incluyendo Chart.js -->
</head>
<body>
    <div class="container mt-5">
        <h3>Avance Semanal de Gestión con Porcentajes</h3>
        
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

        // Obtener la semana actual a partir de la fecha actual
        var currentDate = new Date();
        var currentWeekNumber = getWeekNumber(currentDate);

        // Función para obtener el número de semana del año
        function getWeekNumber(d) {
            var oneJan = new Date(d.getFullYear(), 0, 1);
            var numberOfDays = Math.floor((d - oneJan) / (24 * 60 * 60 * 1000));
            return Math.ceil((d.getDay() + 1 + numberOfDays) / 7);
        }

        // Mostrar progreso usando Chart.js
        var ctx = document.getElementById('weeklyProgressChart').getContext('2d');
        var weeklyProgressChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: weeks.map(w => w.week), // Nombres de las semanas
                datasets: [{
                    label: 'Gestiones realizadas',
                    data: weeks.map(w => w.gestionadas), // Datos de las semanas
                    backgroundColor: weeks.map((w, index) => index + 1 === currentWeekNumber ? 'rgba(75, 192, 192, 0.8)' : 'rgba(54, 162, 235, 0.5)'),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            // Mostrar tanto el número de gestiones como el porcentaje en el tooltip
                            label: function(tooltipItem) {
                                var week = weeks[tooltipItem.dataIndex];
                                return week.week + ': ' + week.gestionadas + ' gestiones (' + week.porcentaje + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Mostrar la semana actual
        alert("Semana actual: " + currentWeekNumber);

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
