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

    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5024',
            // agrega aquí otros campos que uses (sku, subcategory_id, etc.)
        ]);

        // Subir imagen SIEMPRE al disco 'public'
        $data['image_path'] = $data['image']->store('products', 'public');
        unset($data['image']); // evita guardar el UploadedFile

        Product::create($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Producto creado correctamente.',
        ]);

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // agrega aquí otros campos que uses (sku, subcategory_id, etc.)
        ]);

        // Si llega nueva imagen: borra la anterior en disco 'public' y sube la nueva
        if ($request->hasFile('image')) {
            if (!empty($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($data['image']); // nunca persistir 'image'

        $product->update($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Producto actualizado correctamente.',
        ]);

        return redirect()->route('admin.products.edit', $product);
    }

    public function destroy(Product $product)
    {
        if (!empty($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Producto eliminado correctamente.',
        ]);

        return redirect()->route('admin.products.index');
    }

    // Variants
    public function variants(Product $product, Variant $variant)
    {
        return view('admin.products.variants', compact('product', 'variant'));
    }

    public function variantsUpdate(Request $request, Product $product, Variant $variant)
    {
        $data = $request->validate([
            'image' => 'nullable|image|max:1024', // 1MB
            'sku'   => 'required',
            'stock' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            if (!empty($variant->image_path)) {
                Storage::disk('public')->delete($variant->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($data['image']);

        $variant->update($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Variante actualizada correctamente.',
        ]);

        return redirect()->route('admin.products.variants', [$product, $variant]);
    }
}
