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
            <h2 class="text-lg font-semibold mb-4">Pedidos por estado</h2>
            <canvas id="ordersStatusChart"></canvas>
        </div>

        {{-- Gráfico: Pedidos por mes --}}
        <div class="bg-white rounded-lg shadow-lg p-6 relative" style="height: 300px;">
            <h2 class="text-lg font-semibold mb-4">Pedidos por mes ({{ date('Y') }})</h2>
            <canvas id="ordersMonthChart"></canvas>
        </div>
    </div>



    @push('js')
        {{-- Incluir Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            if (ordersByStatusData.length === 0) {
                document.getElementById('ordersStatusChart').parentElement.innerHTML =
                    '<p class="text-center text-gray-500">No hay datos de pedidos por estado</p>';
            }
            if (ordersByMonthData.length === 0) {
                document.getElementById('ordersMonthChart').parentElement.innerHTML =
                    '<p class="text-center text-gray-500">No hay datos de pedidos por mes</p>';
            }


            document.addEventListener('DOMContentLoaded', function() {
                // === Preparar datos seguros ===
                const ordersByStatusLabels = @json($ordersByStatus->keys());
                const ordersByStatusData = @json($ordersByStatus->values()->map(fn($v) => $v ?? 0));

                const ordersByMonthLabels = @json($ordersByMonth->keys()->map(fn($month) => \Carbon\Carbon::create()->month($month)->translatedFormat('M')));
                const ordersByMonthData = @json($ordersByMonth->values()->map(fn($v) => $v ?? 0));

                // === Destruir instancias previas si existen ===
                if (window.ordersStatusChart) {
                    window.ordersStatusChart.destroy();
                }
                if (window.ordersMonthChart) {
                    window.ordersMonthChart.destroy();
                }

                // === Gráfico de barras: Pedidos por estado ===
                const statusCtx = document.getElementById('ordersStatusChart').getContext('2d');
                window.ordersStatusChart = new Chart(statusCtx, {
                    type: 'bar',
                    data: {
                        labels: ordersByStatusLabels,
                        datasets: [{
                            label: 'Total de pedidos',
                            data: ordersByStatusData,
                            backgroundColor: [
                                '#4F46E5', '#22C55E', '#EF4444', '#F59E0B', '#06B6D4', '#8B5CF6'
                            ],
                            borderColor: '#1E293B',

                            borderWidth: 1,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                // === Gráfico de línea: Pedidos por mes ===
                const monthCtx = document.getElementById('ordersMonthChart').getContext('2d');
                window.ordersMonthChart = new Chart(monthCtx, {
                    type: 'line',
                    data: {
                        labels: ordersByMonthLabels,
                        datasets: [{
                            label: 'Total de pedidos',
                            data: ordersByMonthData,
                            fill: false,
                            backgroundColor: [
                                '#4F46E5', '#22C55E', '#EF4444', '#F59E0B', '#06B6D4', '#8B5CF6'
                            ],
                            borderColor: '#1E293B',

                            borderWidth: 3,
                            tension: 0.3,
                            pointRadius: 5,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
