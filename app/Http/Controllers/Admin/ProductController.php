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
        $rules = [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5024',
            // otros campos: sku, subcategory_id, etc.
        ];
        $messages = [
            'name.required'   => 'Por favor, ingresa el nombre del producto.',
            'price.required'  => 'Ingresa el precio del producto.',
            'price.numeric'   => 'El precio debe ser un número.',
            'price.min'       => 'El precio debe ser mayor o igual a 0.',
            'image.required'  => 'Debes subir una imagen del producto.',
            'image.image'     => 'El archivo debe ser una imagen.',
            'image.mimes'     => 'La imagen debe ser: jpeg, png, jpg, gif, webp o svg.',
            'image.max'       => 'La imagen no debe exceder los 5 MB.',
        ];
        $attributes = [
            'name'  => 'nombre del producto',
            'price' => 'precio',
            'image' => 'imagen del producto',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        // Guardar imagen en disco 'public'
        $data['image_path'] = $data['image']->store('products', 'public');
        unset($data['image']);

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
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // otros campos: sku, subcategory_id, etc.
        ];
        $messages = [
            'name.required'   => 'Por favor, ingresa el nombre del producto.',
            'price.required'  => 'Ingresa el precio del producto.',
            'price.numeric'   => 'El precio debe ser un número.',
            'price.min'       => 'El precio debe ser mayor o igual a 0.',
            'image.image'     => 'El archivo debe ser una imagen.',
            'image.mimes'     => 'La imagen debe ser: jpeg, png, jpg, gif o webp.',
            'image.max'       => 'La imagen no debe exceder los 2 MB.',
        ];
        $attributes = [
            'name'  => 'nombre del producto',
            'price' => 'precio',
            'image' => 'imagen del producto',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        // Si hay nueva imagen: borrar la anterior y subir la nueva
        if ($request->hasFile('image')) {
            if (!empty($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($data['image']);

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
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        return view('admin.products.variants', compact('product', 'variant'));
    }

    public function variantsUpdate(Request $request, Product $product, Variant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $rules = [
            'image' => 'nullable|image|max:1024',
            'sku'   => 'required',
            'stock' => 'required|numeric|min:0',
        ];
        $messages = [
            'image.image'     => 'El archivo debe ser una imagen.',
            'image.max'       => 'La imagen no debe exceder 1 MB.',
            'sku.required'    => 'Ingresa el SKU de la variante.',
            'stock.required'  => 'Ingresa el stock de la variante.',
            'stock.numeric'   => 'El stock debe ser un número.',
            'stock.min'       => 'El stock debe ser mayor o igual a 0.',
        ];
        $attributes = [
            'image' => 'imagen de la variante',
            'sku'   => 'SKU',
            'stock' => 'stock',
        ];

        $data = $request->validate($rules, $messages, $attributes);

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
