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
    $rules = [
        'title'     => 'required|string|max:255',
        'start_at'  => 'required|date',
        'end_at'    => 'nullable|date|after_or_equal:start_at',
        'is_active' => 'required|boolean',
        'image'     => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:5024',
    ];

    $messages = [
        'title.required'   => 'Por favor, ingresa el título de la portada.',
        'start_at.required'=> 'Debes especificar la fecha de inicio.',
        'end_at.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        'image.required'   => 'Debes subir una imagen para la portada.',
        'image.image'      => 'El archivo subido debe ser una imagen.',
        'image.mimes'      => 'La imagen debe tener formato: jpg, jpeg, png, webp o svg.',
        'image.max'        => 'La imagen no debe exceder los 5 MB.',
    ];

    $attributes = [
        'title'     => 'título de la portada',
        'start_at'  => 'fecha de inicio',
        'end_at'    => 'fecha de fin',
        'image'     => 'imagen de la portada',
        'is_active' => 'estado (activo/inactivo)',
    ];

    $data = $request->validate($rules, $messages, $attributes);

    // …resto del método sin cambios…
    $data['image_path'] = $data['image']->store('covers', 'public');
    unset($data['image']);

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
        $rules = [
            'title'     => 'required|string|max:255',
            'start_at'  => 'required|date',
            'end_at'    => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'required|boolean',
            'image'     => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:5024',
        ];

        $messages = [
            'title.required'   => 'Por favor, ingresa el título de la portada.',
            'start_at.required' => 'Debes especificar la fecha de inicio.',
            'end_at.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
            'image.required'   => 'Debes subir una imagen para la portada.',
            'image.image'      => 'El archivo subido debe ser una imagen.',
            'image.mimes'      => 'La imagen debe tener formato: jpg, jpeg, png, webp o svg.',
            'image.max'        => 'La imagen no debe exceder los 5 MB.',
        ];

        $attributes = [
            'title'     => 'título de la portada',
            'start_at'  => 'fecha de inicio',
            'end_at'    => 'fecha de fin',
            'image'     => 'imagen de la portada',
            'is_active' => 'estado (activo/inactivo)',
        ];

        $data = $request->validate($rules, $messages, $attributes);


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
