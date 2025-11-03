<x-admin-layout :breadcrumbs="[['name' => 'Dashboard']]">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Tarjeta de bienvenida --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Bienvenido, {{ Auth::user()->name }}</h2>
            <button onclick="window.location.href='{{ route('logout') }}'"
                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                Cerrar sesión
            </button>
        </div>

        {{-- Tarjeta con nombre de empresa --}}
        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-center">
            <h2 class="text-lg font-semibold text-gray-700">HMB Sports</h2>
        </div>
    </div>

    {{-- Sección de gráficas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- Gráfico: Pedidos por estado --}}
        <div class="bg-white rounded-lg shadow-lg p-6 relative" style="height: 300px;">
            <h2 class="text-lg font-semibold mb-0">Pedidos por estado</h2>
            <canvas id="ordersStatusChart"></canvas>
        </div>

        {{-- Gráfico: Pedidos por mes --}}
        <div class="bg-white rounded-lg shadow-lg p-6 relative" style="height: 300px;">
            <h2 class="text-lg font-semibold mb-0">Pedidos por mes ({{ date('Y') }})</h2>
            <canvas id="ordersMonthChart"></canvas>
        </div>
    </div>

    @push('js')
        {{-- Chart.js + plugin etiquetas --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ordersByStatusLabels = @json($ordersByStatus->keys());
                const ordersByStatusData = @json($ordersByStatus->values()->map(fn($v) => $v ?? 0));

                const ordersByMonthLabels = @json($ordersByMonth->keys()->map(fn($m) => \Carbon\Carbon::create()->month($m)->translatedFormat('M')));
                const ordersByMonthData = @json($ordersByMonth->values()->map(fn($v) => $v ?? 0));

                // === GRÁFICO DE BARRAS ===
                const statusCanvas = document.getElementById('ordersStatusChart');
                if (statusCanvas) {
                    const ctx = statusCanvas.getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(99,102,241,0.9)');
                    gradient.addColorStop(1, 'rgba(99,102,241,0.2)');

                    if (window.ordersStatusChart?.destroy) window.ordersStatusChart.destroy();

                    window.ordersStatusChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ordersByStatusLabels,
                            datasets: [{
                                label: 'Total de pedidos',
                                data: ordersByStatusData,
                                backgroundColor: gradient,
                                borderColor: '#312E81',
                                borderWidth: 1,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: true, position: 'top' },
                                datalabels: {
                                    color: '#111',
                                    anchor: 'end',
                                    align: 'top',
                                    font: { weight: 'bold' },
                                    formatter: (value) => value > 0 ? value : ''
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }

                // === GRÁFICO DE LÍNEA ===
                const monthCanvas = document.getElementById('ordersMonthChart');
                if (monthCanvas) {
                    const ctx2 = monthCanvas.getContext('2d');
                    const gradient2 = ctx2.createLinearGradient(0, 0, 0, 400);
                    gradient2.addColorStop(0, 'rgba(59,130,246,0.9)');
                    gradient2.addColorStop(1, 'rgba(59,130,246,0.1)');

                    if (window.ordersMonthChart?.destroy) window.ordersMonthChart.destroy();

                    window.ordersMonthChart = new Chart(ctx2, {
                        type: 'line',
                        data: {
                            labels: ordersByMonthLabels,
                            datasets: [{
                                label: 'Total de pedidos',
                                data: ordersByMonthData,
                                fill: true,
                                backgroundColor: gradient2,
                                borderColor: '#1E3A8A',
                                borderWidth: 2,
                                tension: 0.3,
                                pointRadius: 4,
                                pointBackgroundColor: '#1E40AF',
                                pointHoverRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: true, position: 'top' },
                                datalabels: {
                                    color: '#111',
                                    anchor: 'end',
                                    align: 'top',
                                    font: { weight: 'bold' },
                                    formatter: (value) => value > 0 ? value : ''
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }
            });
        </script>
    @endpush
</x-admin-layout>
