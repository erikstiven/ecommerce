<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoverController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage covers');
    }

    public function index()
    {
        $covers = Cover::orderBy('order')->get();
        return view('admin.covers.index', compact('covers'));
    }

    public function create()
    {
        return view('admin.covers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'start_at'  => 'required|date',
            'end_at'    => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'required|boolean',
            'image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        // Guardar la imagen SIEMPRE en el disco 'public'
        $data['image_path'] = $data['image']->store('covers', 'public');
        unset($data['image']); // no intentamos guardar el UploadedFile en la BD

        $cover = Cover::create($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Portada creada!',
            'text'  => 'La portada ha sido creada exitosamente.',
        ]);

        return redirect()->route('admin.covers.edit', $cover);
    }

    public function show(Cover $cover)
    {
        //
    }

    public function edit(Cover $cover)
    {
        return view('admin.covers.edit', compact('cover'));
    }

    public function update(Request $request, Cover $cover)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'start_at'  => 'required|date',
            'end_at'    => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'required|boolean',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        // Si llega nueva imagen, borrar la anterior del disco 'public' y subir la nueva al mismo disco
        if (!empty($data['image'])) {
            if (!empty($cover->image_path)) {
                Storage::disk('public')->delete($cover->image_path);
            }
            $data['image_path'] = $data['image']->store('covers', 'public');
            unset($data['image']);
        } else {
            // evitar que quede la clave 'image' sin usar
            unset($data['image']);
        }

        $cover->update($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Portada actualizada!',
            'text'  => 'La portada ha sido actualizada exitosamente.',
        ]);

        return redirect()->route('admin.covers.edit', $cover);
    }

    public function destroy(Cover $cover)
    {
        // Borra el archivo físico si existe
        if (!empty($cover->image_path)) {
            Storage::disk('public')->delete($cover->image_path);
        }

        $cover->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Portada eliminada!',
            'text'  => 'La portada ha sido eliminada correctamente.',
        ]);

        return redirect()->route('admin.covers.index');
    }
}
