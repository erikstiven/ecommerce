@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos más vendidos</h1>
    <canvas id="topSalesChart" width="600" height="300" style="border: 1px solid #000;"></canvas>

    <h1 class="mt-10">Productos con menos ventas</h1>
    <canvas id="lowSalesChart" width="600" height="300" style="border: 1px solid #000;"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos para productos más vendidos
    const topLabels = @json($topLabels);
    const topData = @json($topData);

    const ctxTop = document.getElementById('topSalesChart').getContext('2d');
    new Chart(ctxTop, {
        type: 'bar',
        data: {
            labels: topLabels,
            datasets: [{
                label: 'Cantidad vendida',
                data: topData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                maxBarThickness: 60
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // Datos para productos con menos ventas
    const lowLabels = @json($lowLabels);
    const lowData = @json($lowData);

    const ctxLow = document.getElementById('lowSalesChart').getContext('2d');
    new Chart(ctxLow, {
        type: 'bar',
        data: {
            labels: lowLabels,
            datasets: [{
                label: 'Cantidad vendida',
                data: lowData,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',  // color rojo para diferenciar
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                maxBarThickness: 60
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection
