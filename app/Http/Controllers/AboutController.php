<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {

        // Retornamos la vista con la variable $servicios
        return view('about.index');
    }
}
