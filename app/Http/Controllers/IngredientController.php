<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Menu;


class IngredientController extends Controller
{
    public function index(){
        
    }

    public function store(){
        
    }
    
    public function update(Request $request, $menu_id){
        $ingredients = Ingredient::where('menu_id', $menu_id)->get();
        $ingredientsCount = $ingredients->count();
        for($index=0;$index<$ingredientsCount;$index++){
            $ingredients[$index]->name = $request->ingredients[$index]['name'];
            $ingredients[$index]->quantity = $request->ingredients[$index]['quantity'];
            $ingredients[$index]->unit = $request->ingredients[$index]['unit'];
            $ingredients[$index]->save();
        }
        for($index=$ingredientsCount;$index<count($request->ingredients);$index++){
            $newIngredient = Ingredient::create([  
            'menu_id' => $menu_id,
            'name' => $request->ingredients[$index]['name'],
            'quantity' => $request->ingredients[$index]['quantity'],
            'unit' => $request->ingredients[$index]['unit'],
        ]);
        }
        return redirect()->route('menu.index')->with('success', 'Sukses update bahan.');    
    }
}