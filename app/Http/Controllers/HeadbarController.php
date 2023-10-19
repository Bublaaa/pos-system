<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;


class HeadbarController extends Controller
{
    public function index()
    {
        return view('../layouts/contents/dashboard');
    }
    public function addStock(){
        $ingredientNames = Ingredient::distinct()->pluck('name')->sort();
        return view('../layouts/contents/addStock') -> with(['ingredientNames' => $ingredientNames]);
    }
}