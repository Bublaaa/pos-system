<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index(){
        return view('../layouts/ownerView');
    }
    public function register(){
        return view('../auth.register'); 
    }
}