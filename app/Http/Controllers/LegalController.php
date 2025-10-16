<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function index()
    {

        // Retornamos la vista con la variable $servicios
        return view('legal.index');
    }
}
