<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Auth::id());
        // dd(Auth::user());
        // dd(Auth::check());
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function secret()
    {
        return view('secret');
    }
}
