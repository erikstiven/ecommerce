<x-admin-layout :breadcrumbs="[['name' => __('Dashboard')]]">

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 auto-rows-fr">
        <div class="rounded-lg border border-slate-200/70 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">Pedidos del mes</p>
            <p class="text-2xl font-semibold text-slate-900">{{ $kpis['totalMonth'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-amber-200/60 bg-amber-50/70 p-4">
            <p class="text-xs uppercase tracking-wide text-amber-600">Pedidos pendientes</p>
            <p class="text-2xl font-semibold text-amber-700">{{ $kpis['pending'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-emerald-200/60 bg-emerald-50/70 p-4">
            <p class="text-xs uppercase tracking-wide text-emerald-600">Pedidos entregados</p>
            <p class="text-2xl font-semibold text-emerald-700">{{ $kpis['delivered'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-rose-200/60 bg-rose-50/70 p-4">
            <p class="text-xs uppercase tracking-wide text-rose-600">Pedidos cancelados</p>
            <p class="text-2xl font-semibold text-rose-700">{{ $kpis['canceled'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Acceso a estadísticas --}}
    <div class="mt-6 rounded-lg border border-slate-200/70 bg-slate-50 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-700">Estadísticas</p>
                <p class="text-xs text-slate-500">Visualiza todas las gráficas en un carrusel dedicado.</p>
            </div>
            <a href="{{ route('admin.estadisticas') }}"
                class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                Ver estadísticas
            </a>
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
</x-admin-layout>
