<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Family;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage categories');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::orderBy('id', 'desc')->with('family')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $families = Family::all();
        return view('admin.categories.create', compact('families'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'family_id' => 'required|exists:families,id',
            'name'      => 'required',
        ];
        $messages = [
            'family_id.required' => 'Debes seleccionar una familia.',
            'family_id.exists'   => 'La familia seleccionada no existe.',
            'name.required'      => 'El nombre de la categoría es obligatorio.',
        ];
        $attributes = [
            'family_id' => 'familia',
            'name'      => 'nombre de la categoría',
        ];

        // Validar con reglas, mensajes y atributos personalizados
        $data = $request->validate($rules, $messages, $attributes);

        Category::create($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Categoría creada correctamente.',
        ]);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        $families = Family::all();
        return view('admin.categories.edit', compact('category', 'families'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'family_id' => 'required|exists:families,id',
            'name'      => 'required',
        ];
        $messages = [
            'family_id.required' => 'Debes seleccionar una familia.',
            'family_id.exists'   => 'La familia seleccionada no existe.',
            'name.required'      => 'El nombre de la categoría es obligatorio.',
        ];
        $attributes = [
            'family_id' => 'familia',
            'name'      => 'nombre de la categoría',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        $category->update($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Categoría actualizada correctamente.',
        ]);

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        // if ($category->subcategories()->count() > 0) {
        //     session()->flash('swal', [
        //         'icon' => 'error',
        //         'title' => '¡Upss!',
        //         'text' => 'No se puede eliminar la familia porque tiene subcategorías asociadas.',
        //     ]);
        //     return redirect()->route('admin.categories.edit', $category);
        // }
        if ($category->subcategories()->count() > 0) {
            session()->flash('swal', [
                'icon'  => 'error',
                'title' => '¡Upss!',
                'text'  => 'No se puede eliminar la categoría porque tiene subcategorías asociadas.',
            ]);
            return redirect()->route('admin.categories.edit', $category);
        }

        $category->delete();
        // Flash message
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Categoria eliminada correctamente.',
        ]);
        return redirect()->route('admin.categories.index');
    }
}
