<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cover;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $covers = Cover::where('is_active', true)
            ->whereDate('start_at', '<=', now())
            ->where(function ($query) {
                $query->where('end_at', '>=', now())
                    ->orWhereNull('end_at');
            })
            ->get();

        $lastProducts = Product::orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        return view('welcome', compact('covers', 'lastProducts'));
    }
}
