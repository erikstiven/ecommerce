<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Variant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage products');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::orderby('id', 'desc')->paginate();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Storage::delete($product->image_path);
        $product->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Producto eliminado correctamente.',
        ]);
        return redirect()->route('admin.products.index');
    }

    //variants
    public function variants(Product $product, Variant $variant)
    {
        return view('admin.products.variants', compact('product', 'variant'));
    }


    public function variantsUpdate(Request $request, Product $product, Variant $variant)
    {

        $data = $request->validate([
            'image' => 'nullable|image|max:1024', // 1MB Max
            'sku' => 'required',
            'stock' => 'required |numeric |min:0',
        ]);

        if ($request->image) {

            if ($variant->image_path) {
                Storage::delete($variant->image_path);
            }

            $data['image_path'] = $request->image->store('products');
        }
        $variant->update($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Variante actualizado correctamente.',
        ]);
        return redirect()->route('admin.products.variants', [$product, $variant]);
    }
}
