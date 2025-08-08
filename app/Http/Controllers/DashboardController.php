<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 5 productos más vendidos
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // 5 productos con menos ventas (que hayan vendido algo)
        $lowProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderBy('total_sold')
            ->limit(5)
            ->get();

        $topLabels = $topProducts->pluck('name');
        $topData = $topProducts->pluck('total_sold');

        $lowLabels = $lowProducts->pluck('name');
        $lowData = $lowProducts->pluck('total_sold');

        return view('dashboard', compact('topLabels', 'topData', 'lowLabels', 'lowData'));
    }
}
