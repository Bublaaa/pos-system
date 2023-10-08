<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HeadbarController extends Controller
{
    public function index()
    {
        return view('../layouts/contents/dashboard');
    }
}