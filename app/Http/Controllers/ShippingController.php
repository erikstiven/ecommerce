<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShippingController extends Controller
{
    //index
    public function index()
    {
        // Logic to display shipping options
        return view('shipping.index');
    }
}
