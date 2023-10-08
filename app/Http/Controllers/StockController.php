<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function report()
    {
        return view('../layouts/contents/stockReport');
    }
    public function add()
    {
        return view('../layouts/contents/addStock');
    }
}