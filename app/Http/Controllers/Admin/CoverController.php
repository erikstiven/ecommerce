<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $covers = Cover::orderBy('order')->get();
        return view('admin.covers.index', compact('covers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.covers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'required|boolean',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        $data['image_path'] = Storage::put('covers', $data['image']);

        $cover = Cover::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Portada creada!',
            'text' => 'La portada ha sido creada exitosamente.',
        ]);

        return redirect()->route('admin.covers.edit', $cover);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cover $cover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cover $cover)
    {
        return view('admin.covers.edit', compact('cover'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cover $cover)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);
        //si hay algo en el campo imagen
        if (isset($data['image'])) {
            Storage::delete($cover->image_path);

            $data['image_path'] = Storage::put('covers', $data['image']);
        }

        $cover->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Portada actualizada!',
            'text' => 'La portada ha sido actualizada exitosamente.',
        ]);

        return redirect()->route('admin.covers.edit', $cover);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cover $cover)
    {
        //
    }
}
