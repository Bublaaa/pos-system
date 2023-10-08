<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function absent(){
        return view('../layouts/contents/absent');
    }
    public function stock(){
        return view('../layouts/contents/stock');
    }
}