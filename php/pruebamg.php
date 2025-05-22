<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Unidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="container mt-5">
    <h3 class="mb-4">Unidades Diligenciadas por Docente (Año 2025)</h3>
    <canvas id="graficaUnidades"></canvas>

    <script>
        fetch('data.php')
            .then(res => res.json())
            .then(data => {
                const labels = data.map(d => d.nombre_docente);
                const unidades = data.map(d => d.unidades_diligenciadas);
                const asignaturas = data.map(d => d.nombre_asignatura);

                const ctx = document.getElementById('graficaUnidades').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Unidades diligenciadas',
                            data: unidades,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Asignatura: ${asignaturas[context.dataIndex]}, Unidades: ${context.raw}`;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Docentes con 3-5 unidades diligenciadas'
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                stepSize: 1,
                                max: 5
                            }
                        }
                    }
                });
            });
    </script>
</body>

</html>