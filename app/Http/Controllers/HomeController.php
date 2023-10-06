<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $position = auth()->user()->position;
        
        // Use $position to determine which view to load
        if ($position === 'owner') {
            return view('ownerView');
        } elseif ($position === 'headbar') {
            return view('headbarView');
        }  else {
            return view('home');
        }
    }
}