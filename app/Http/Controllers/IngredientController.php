<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(){
        
    }

    public function store(){
        $ingredient = [
            'name' => $request->ingredientName,
            'quantity' => $request->ingredientQuantity,
            'unit' => $request->ingredientUnit,
        ];

        $this->ingredients[] = $ingredient;

        // dd($this->ingredients);
        dd($request->ingredientName);
    }
    public function edit(){
        
    }
}