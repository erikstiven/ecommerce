<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    //constructor
    public function __construct()
    {
        $this->middleware('can:manage options');
    }
    public function index()
    {
        // Logic to retrieve and display options
        return view('admin.options.index');
    }
}
