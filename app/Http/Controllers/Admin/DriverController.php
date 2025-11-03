<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage drivers');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.drivers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.drivers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id'      => 'required|exists:users,id',
            'type'         => 'required|in:1,2', // 1: Moto, 2: Auto
            'plate_number' => 'required|string',
        ];
        $messages = [
            'user_id.required'      => 'Debes asignar un usuario como conductor.',
            'user_id.exists'        => 'El usuario seleccionado no existe.',
            'type.required'         => 'Selecciona el tipo de vehículo (moto o auto).',
            'type.in'               => 'El tipo de vehículo debe ser 1 (moto) o 2 (auto).',
            'plate_number.required' => 'Debes ingresar el número de placa.',
        ];
        $attributes = [
            'user_id'      => 'usuario',
            'type'         => 'tipo de vehículo',
            'plate_number' => 'número de placa',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        Driver::create($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Conductor creado correctamente.',
        ]);

        return redirect()->route('admin.drivers.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        return view('admin.drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        $users = User::all();

        return view('admin.drivers.edit', compact('driver', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $rules = [
            'user_id'      => 'required|exists:users,id',
            'type'         => 'required|in:1,2',
            'plate_number' => 'required|string',
        ];
        $messages = [
            'user_id.required'      => 'Debes asignar un usuario como conductor.',
            'user_id.exists'        => 'El usuario seleccionado no existe.',
            'type.required'         => 'Selecciona el tipo de vehículo (moto o auto).',
            'type.in'               => 'El tipo de vehículo debe ser 1 (moto) o 2 (auto).',
            'plate_number.required' => 'Debes ingresar el número de placa.',
        ];
        $attributes = [
            'user_id'      => 'usuario',
            'type'         => 'tipo de vehículo',
            'plate_number' => 'número de placa',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        $driver->update($data);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'Conductor actualizado correctamente.',
        ]);

        return redirect()->route('admin.drivers.edit', $driver);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Conductor eliminado correctamente.',
        ]);
        return redirect()->route('admin.drivers.index');
    }
}
