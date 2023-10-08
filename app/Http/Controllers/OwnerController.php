<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index(){
        return view('../layouts/contents/dashboard');
    }
    public function register(){
        return view('../auth.register'); 
    }
}