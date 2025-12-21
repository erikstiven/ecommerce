<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\ShipmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:access dashboard');
    }

    public function index()
    {
        $year = now()->year;

        $orderStatusCounts = Order::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $ordersByStatus = collect(OrderStatus::cases())
            ->mapWithKeys(fn(OrderStatus $status) => [
                $status->name => (int) ($orderStatusCounts[$status->value] ?? 0),
            ]);

        $statusColors = collect(OrderStatus::cases())
            ->mapWithKeys(fn(OrderStatus $status) => [
                $status->name => match ($status) {
                    OrderStatus::Pendiente,
                    OrderStatus::EsperandoAprobacion => '#f59e0b',
                    OrderStatus::Procesando => '#3b82f6',
                    OrderStatus::Enviado => '#6366f1',
                    OrderStatus::Completado => '#10b981',
                    OrderStatus::Cancelado,
                    OrderStatus::Fallido,
                    OrderStatus::Reembolsado => '#ef4444',
                },
            ]);

        $ordersByMonthRaw = Order::query()
            ->selectRaw('MONTH(created_at) as month, count(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = collect(range(1, 12));
        $ordersByMonth = $months->mapWithKeys(fn(int $month) => [
            $month => (int) ($ordersByMonthRaw[$month] ?? 0),
        ]);

        $monthLabels = $months->map(fn(int $month) => Carbon::create()->month($month)->translatedFormat('M'));

        $pendingStatuses = [
            OrderStatus::Pendiente->value,
            OrderStatus::EsperandoAprobacion->value,
        ];

        $kpis = [
            'totalMonth' => Order::whereYear('created_at', $year)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'pending' => Order::whereIn('status', $pendingStatuses)->count(),
            'delivered' => Order::where('status', OrderStatus::Completado->value)->count(),
            'canceled' => Order::where('status', OrderStatus::Cancelado->value)->count(),
        ];

        $latestOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = OrderItem::query()
            ->select('product_title', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_title')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $ordersByFamily = OrderItem::query()
            ->select('families.name', DB::raw('COUNT(DISTINCT order_items.order_id) as total'))
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->join('families', 'families.id', '=', 'categories.family_id')
            ->groupBy('families.name')
            ->orderByDesc('total')
            ->get();

        $shipmentStatusCounts = Shipment::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $shipmentsByStatus = collect(ShipmentStatus::cases())
            ->mapWithKeys(fn(ShipmentStatus $status) => [
                $status->name => (int) ($shipmentStatusCounts[$status->value] ?? 0),
            ]);

        return view('admin.dashboard', [
            'ordersByStatus' => $ordersByStatus,
            'statusColors' => $statusColors,
            'ordersByMonth' => $ordersByMonth,
            'monthLabels' => $monthLabels,
            'kpis' => $kpis,
            'latestOrders' => $latestOrders,
            'topProducts' => $topProducts,
            'ordersByFamily' => $ordersByFamily,
            'shipmentsByStatus' => $shipmentsByStatus,
        ]);
    }
}
