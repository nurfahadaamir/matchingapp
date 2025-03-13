<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        // Apply middleware if needed
        // $this->middleware('auth')->only(['dashboard']);
    }

    public function index()
    {
        return view('home'); // This should match your Blade file (home.blade.php)
    }

    public function dashboard()
    {
        return view('dashboard'); // Example for authenticated users
    }
}
