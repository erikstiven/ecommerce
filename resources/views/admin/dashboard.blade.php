<x-admin-layout :breadcrumbs="[['name' => __('Dashboard')]]">

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 auto-rows-fr">
        <div class="rounded-lg border border-slate-200/70 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">Pedidos del mes</p>
            <p class="text-2xl font-semibold text-slate-900">{{ $kpis['totalMonth'] }}</p>
        </div>
        <div class="rounded-lg border border-amber-200/60 bg-amber-50/70 p-4">
            <p class="text-xs uppercase tracking-wide text-amber-600">Pedidos pendientes</p>
            <p class="text-2xl font-semibold text-amber-700">{{ $kpis['pending'] }}</p>
        </div>
        <div class="rounded-lg border border-emerald-200/60 bg-emerald-50/70 p-4">
            <p class="text-xs uppercase tracking-wide text-emerald-600">Pedidos entregados</p>
            <p class="text-2xl font-semibold text-emerald-700">{{ $kpis['delivered'] }}</p>
        </div>
        <div class="rounded-lg border border-rose-200/60 bg-rose-50/70 p-4">
            <p class="text-xs uppercase tracking-wide text-rose-600">Pedidos cancelados</p>
            <p class="text-2xl font-semibold text-rose-700">{{ $kpis['canceled'] }}</p>
        </div>
    </div>

    {{-- Slider de gráficas --}}
    <div class="mt-6" x-data="{ chartIndex: 0 }">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-slate-800">Gráficas</h2>
            <div class="flex items-center gap-2">
                <button type="button"
                    class="h-9 w-9 rounded-full border border-slate-200 text-slate-500 hover:bg-slate-50"
                    @click="chartIndex = (chartIndex + 4) % 5">
                    ‹
                </button>
                <button type="button"
                    class="h-9 w-9 rounded-full border border-slate-200 text-slate-500 hover:bg-slate-50"
                    @click="chartIndex = (chartIndex + 1) % 5">
                    ›
                </button>
        </div>
    </div>

    {{-- Últimos pedidos --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4">Últimos pedidos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase text-gray-500 border-b">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Cliente</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($latestOrders as $order)
                        <tr>
                            <td class="px-4 py-2 font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->user?->name ?? 'Invitado' }}</td>
                            <td class="px-4 py-2">{{ $order->status?->name ?? 'Sin estado' }}</td>
                            <td class="px-4 py-2">{{ $order->created_at?->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.orders.index') }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Ver pedidos
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                No hay pedidos recientes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-300 ease-in-out"
                :style="`transform: translateX(-${chartIndex * 100}%)`">
                <div class="w-full shrink-0 px-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col min-h-[320px] overflow-hidden">
                        <h2 class="text-lg font-semibold mb-0">Pedidos por estado</h2>
                        <div class="relative flex-1 min-h-[220px] overflow-hidden">
                            <canvas id="ordersStatusChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
                <div class="w-full shrink-0 px-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col min-h-[320px] overflow-hidden">
                        <h2 class="text-lg font-semibold mb-0">Pedidos por mes ({{ date('Y') }})</h2>
                        <div class="relative flex-1 min-h-[220px] overflow-hidden">
                            <canvas id="ordersMonthChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
                <div class="w-full shrink-0 px-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col min-h-[320px] overflow-hidden">
                        <h2 class="text-lg font-semibold mb-0">Productos más vendidos (Top 5)</h2>
                        <div class="relative flex-1 min-h-[220px] overflow-hidden">
                            <canvas id="topProductsChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
                <div class="w-full shrink-0 px-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col min-h-[320px] overflow-hidden">
                        <h2 class="text-lg font-semibold mb-0">Pedidos por familia</h2>
                        <div class="relative flex-1 min-h-[220px] overflow-hidden">
                            <canvas id="ordersFamilyChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
                <div class="w-full shrink-0 px-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col min-h-[320px] overflow-hidden">
                        <h2 class="text-lg font-semibold mb-0">Estado de envíos</h2>
                        <div class="relative flex-1 min-h-[220px] overflow-hidden">
                            <canvas id="shipmentsStatusChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @push('js')
        {{-- Chart.js + plugin etiquetas --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ordersByStatusLabels = @json($ordersByStatus->keys());
                const ordersByStatusData = @json($ordersByStatus->values());
                const ordersByStatusColors = @json($statusColors->values());

                const ordersByMonthLabels = @json($monthLabels);
                const ordersByMonthData = @json($ordersByMonth->values());

                const topProductsLabels = @json($topProducts->pluck('product_title'));
                const topProductsData = @json($topProducts->pluck('total_qty'));

                const ordersByFamilyLabels = @json($ordersByFamily->pluck('name'));
                const ordersByFamilyData = @json($ordersByFamily->pluck('total'));

                const shipmentsStatusLabels = @json($shipmentsByStatus->keys());
                const shipmentsStatusData = @json($shipmentsByStatus->values());

                // === GRÁFICO DE BARRAS ===
                const statusCanvas = document.getElementById('ordersStatusChart');
                if (statusCanvas) {
                    const ctx = statusCanvas.getContext('2d');

                    if (window.ordersStatusChart?.destroy) window.ordersStatusChart.destroy();

                    window.ordersStatusChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ordersByStatusLabels,
                            datasets: [{
                                label: 'Total de pedidos',
                                data: ordersByStatusData,
                                backgroundColor: ordersByStatusColors,
                                borderColor: ordersByStatusColors,
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

                // === GRÁFICO TOP PRODUCTOS ===
                const productsCanvas = document.getElementById('topProductsChart');
                if (productsCanvas) {
                    const ctx3 = productsCanvas.getContext('2d');

                    if (window.topProductsChart?.destroy) window.topProductsChart.destroy();

                    window.topProductsChart = new Chart(ctx3, {
                        type: 'bar',
                        data: {
                            labels: topProductsLabels,
                            datasets: [{
                                label: 'Unidades vendidas',
                                data: topProductsData,
                                backgroundColor: 'rgba(16,185,129,0.7)',
                                borderColor: '#059669',
                                borderWidth: 1,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
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

                // === GRÁFICO PEDIDOS POR FAMILIA ===
                const familyCanvas = document.getElementById('ordersFamilyChart');
                if (familyCanvas) {
                    const ctx4 = familyCanvas.getContext('2d');

                    if (window.ordersFamilyChart?.destroy) window.ordersFamilyChart.destroy();

                    window.ordersFamilyChart = new Chart(ctx4, {
                        type: 'bar',
                        data: {
                            labels: ordersByFamilyLabels,
                            datasets: [{
                                label: 'Pedidos',
                                data: ordersByFamilyData,
                                backgroundColor: 'rgba(99,102,241,0.7)',
                                borderColor: '#4338ca',
                                borderWidth: 1,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
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

                // === GRÁFICO ESTADO DE ENVÍOS ===
                const shipmentCanvas = document.getElementById('shipmentsStatusChart');
                if (shipmentCanvas) {
                    const ctx5 = shipmentCanvas.getContext('2d');

                    if (window.shipmentsStatusChart?.destroy) window.shipmentsStatusChart.destroy();

                    window.shipmentsStatusChart = new Chart(ctx5, {
                        type: 'doughnut',
                        data: {
                            labels: shipmentsStatusLabels,
                            datasets: [{
                                data: shipmentsStatusData,
                                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' },
                                datalabels: {
                                    color: '#111',
                                    formatter: (value) => value > 0 ? value : ''
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
