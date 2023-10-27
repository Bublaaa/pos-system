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
        $ingredientArray=[];
        $ingredientsCount = $ingredients->count();
        if(count($request->ingredients)==$ingredientsCount){
            // Rearrange index form input request into new oarray
            foreach($request->ingredients as $index => $ingredient){
                $ingredientArray[] = [
                    'name' => $ingredient['name'],
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ];
            }
            for($index=0;$index<count($ingredientArray);$index++){
                $ingredients[$index]->name = $ingredientArray[$index]['name'];
                $ingredients[$index]->quantity = $ingredientArray[$index]['quantity'];
                $ingredients[$index]->unit = $ingredientArray[$index]['unit'];
                $ingredients[$index]->save();
            }
        }
        elseif(count($request->ingredients)>$ingredientsCount) {
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
        }
        else {
            for($index=0;$index<count($request->ingredients);$index++){
                $ingredients[$index]->name = $request->ingredients[$index]['name'];
                $ingredients[$index]->quantity = $request->ingredients[$index]['quantity'];
                $ingredients[$index]->unit = $request->ingredients[$index]['unit'];
                $ingredients[$index]->save();
            }
            for($index=count($request->ingredients);$index<$ingredientsCount;$index++){
                $ingredients[$index]->delete();
            }
        }
        return redirect()->route('menu.index')->with('success', 'Sukses update bahan.');   
    }
    public function destroy(Ingredient $ingredient){
        
    }
}