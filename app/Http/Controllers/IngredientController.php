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
        // Rearrange index form input request into new oarray
        foreach($request->ingredients as $index => $ingredient){
            $ingredientArray[] = [
                'name' => ucwords($ingredient['name']),
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ];
        }
        if(count($ingredientArray)==$ingredientsCount){
            for($index=0;$index<count($ingredientArray);$index++){
                $ingredients[$index]->name = $ingredientArray[$index]['name'];
                $ingredients[$index]->quantity = $ingredientArray[$index]['quantity'];
                $ingredients[$index]->unit = $ingredientArray[$index]['unit'];
                $ingredients[$index]->save();
            }
        }
        elseif(count($ingredientArray)>$ingredientsCount) {
            for($index=0;$index<$ingredientsCount;$index++){
                $ingredients[$index]->name = $ingredientArray[$index]['name'];
                $ingredients[$index]->quantity = $ingredientArray[$index]['quantity'];
                $ingredients[$index]->unit = $ingredientArray[$index]['unit'];
                $ingredients[$index]->save();
            }
            for($index=$ingredientsCount;$index<count($ingredientArray);$index++){
                $newIngredient = Ingredient::create([  
                'menu_id' => $menu_id,
                'name' => $ingredientArray[$index]['name'],
                'quantity' => $ingredientArray[$index]['quantity'],
                'unit' => $ingredientArray[$index]['unit'],
            ]);
            }
        }
        else {
            for($index=0;$index<count($ingredientArray);$index++){
                $ingredients[$index]->name = $ingredientArray[$index]['name'];
                $ingredients[$index]->quantity = $ingredientArray[$index]['quantity'];
                $ingredients[$index]->unit = $ingredientArray[$index]['unit'];
                $ingredients[$index]->save();
            }
            for($index=count($ingredientArray);$index<$ingredientsCount;$index++){
                $ingredients[$index]->delete();
            }
        }
        return redirect()->route('menu.index')->with('success', 'Sukses update bahan.');   
    }
    public function destroy(Ingredient $ingredient){
        
    }
}