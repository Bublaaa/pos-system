<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function add(){
        return view('../layouts/contents/addmenu');
    }
    public function edit(){
        return view('../layouts/contents/editmenu');
    }
}