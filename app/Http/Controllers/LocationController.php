<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {

        // Retornamos la vista con la variable $servicios
        return view('location.index');
    }
}
