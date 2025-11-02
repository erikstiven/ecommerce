<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query    = $request->input('search');
        $products = Product::searchByName($query)->paginate(12);

        return view('search.index', [
            'products' => $products,
            'query'    => $query,
        ]);
    }
}
