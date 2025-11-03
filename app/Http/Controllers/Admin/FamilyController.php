<?php

namespace App\Http\Controllers\Admin;

use App\Models\Family;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:manage families');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $families = Family::orderBy('id', 'desc')->paginate(10);
        return view('admin.families.index', compact('families'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.families.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = ['name' => 'required'];
        $messages = [
            'name.required' => 'Por favor, ingresa el nombre de la familia.',
        ];
        $attributes = [
            'name' => 'nombre de la familia',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        Family::create($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Familia creada correctamente.',
        ]);

        return redirect()->route('admin.families.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family)
    {
        //
        return view('admin.families.edit', compact('family'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Family $family)
    {
        $rules = ['name' => 'required'];
        $messages = [
            'name.required' => 'Por favor, ingresa el nombre de la familia.',
        ];
        $attributes = [
            'name' => 'nombre de la familia',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        $family->update($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Familia actualizada correctamente.',
        ]);

        return redirect()->route('admin.families.edit', $family);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        //
        if ($family->categories()->count() > 0) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => '¡Upss!',
                'text' => 'No se puede eliminar la familia porque tiene categorías asociadas.',
            ]);
            return redirect()->route('admin.families.edit', $family);
        }
        $family->delete();
        // Flash message
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Familia eliminada correctamente.',
        ]);
        return redirect()->route('admin.families.index');
    }
}
