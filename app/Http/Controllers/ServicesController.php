<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        // Datos simulados para las tarjetas de servicios
        $servicios = [
            [
                'img' => asset('img/serigrafia.jpg'),
                'title' => 'Serigrafía',
                'desc' => 'Impresión textil de alta durabilidad con tintas profesionales.'
            ],
            [
                'img' => asset('img/bordado.jpg'),
                'title' => 'Bordado',
                'desc' => 'Acabado premium con hilos de alta calidad.'
            ],
            [
                'img' => asset('img/sublimado.jpg'),
                'title' => 'Sublimado',
                'desc' => 'Ideal para prendas deportivas y personalizadas.'
            ],
        ];

        // Retornamos la vista con la variable $servicios
        return view('services.index', compact('servicios'));
    }
}
