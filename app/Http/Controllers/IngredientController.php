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
        $regularIngredients = Ingredient::where('menu_id', $menu_id)->where('size','Regular')->get();
        $largeIngredients = Ingredient::where('menu_id', $menu_id)->where('size','Large')->get();
        $ingredientArray=[];
        $largeIngredientArray=[];
        $ingredientsCount = $regularIngredients->count();
        $largeIngredientsCount = $largeIngredients->count();
        
        // REGULAR
        if($request->ingredients){
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
                    $regularIngredients[$index]->name = $ingredientArray[$index]['name'];
                    $regularIngredients[$index]->quantity = $ingredientArray[$index]['quantity'];
                    $regularIngredients[$index]->unit = $ingredientArray[$index]['unit'];
                    $regularIngredients[$index]->save();
                }
            }
            elseif(count($ingredientArray)>$ingredientsCount) {
                for($index=0;$index<$ingredientsCount;$index++){
                    $regularIngredients[$index]->name = $ingredientArray[$index]['name'];
                    $regularIngredients[$index]->quantity = $ingredientArray[$index]['quantity'];
                    $regularIngredients[$index]->unit = $ingredientArray[$index]['unit'];
                    $regularIngredients[$index]->save();
                }
                for($index=$ingredientsCount;$index<count($ingredientArray);$index++){
                    $newIngredient = Ingredient::create([  
                    'menu_id' => $menu_id,
                    'name' => $ingredientArray[$index]['name'],
                    'quantity' => $ingredientArray[$index]['quantity'],
                    'unit' => $ingredientArray[$index]['unit'],
                    'size' => 'Regular',
                ]);
                }
            }
            else {
                for($index=0;$index<count($ingredientArray);$index++){
                    $regularIngredients[$index]->name = $ingredientArray[$index]['name'];
                    $regularIngredients[$index]->quantity = $ingredientArray[$index]['quantity'];
                    $regularIngredients[$index]->unit = $ingredientArray[$index]['unit'];
                    $regularIngredients[$index]->save();
                }
                for($index=count($ingredientArray);$index<$ingredientsCount;$index++){
                    $regularIngredients[$index]->delete();
                }
            }
        }
        // LARGE
        if($request->largeIngredients){
            // Rearrange index form input request into new oarray
            foreach($request->largeIngredients as $index => $ingredient){
                $largeIngredientArray[] = [
                    'name' => ucwords($ingredient['name']),
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ];
            }

            if(count($largeIngredientArray)==$largeIngredientsCount){
                for($index=0;$index<count($largeIngredientArray);$index++){
                    $largeIngredients[$index]->name = $largeIngredientArray[$index]['name'];
                    $largeIngredients[$index]->quantity = $largeIngredientArray[$index]['quantity'];
                    $largeIngredients[$index]->unit = $largeIngredientArray[$index]['unit'];
                    $largeIngredients[$index]->save();
                }
            }
            elseif(count($largeIngredientArray)>$largeIngredientsCount) {
                for($index=0;$index<$largeIngredientsCount;$index++){
                    $largeIngredients[$index]->name = $largeIngredientArray[$index]['name'];
                    $largeIngredients[$index]->quantity = $largeIngredientArray[$index]['quantity'];
                    $largeIngredients[$index]->unit = $largeIngredientArray[$index]['unit'];
                    $largeIngredients[$index]->save();
                }
                for($index=$largeIngredientsCount;$index<count($largeIngredientArray);$index++){
                    $newIngredient = Ingredient::create([  
                    'menu_id' => $menu_id,
                    'name' => $largeIngredientArray[$index]['name'],
                    'quantity' => $largeIngredientArray[$index]['quantity'],
                    'unit' => $largeIngredientArray[$index]['unit'],
                    'size' => 'Large',
                ]);
                }
            }
            else {
                for($index=0;$index<count($largeIngredientArray);$index++){
                    $largeIngredients[$index]->name = $largeIngredientArray[$index]['name'];
                    $largeIngredients[$index]->quantity = $largeIngredientArray[$index]['quantity'];
                    $largeIngredients[$index]->unit = $largeIngredientArray[$index]['unit'];
                    $largeIngredients[$index]->save();
                }
                for($index=count($largeIngredientArray);$index<$largeIngredientsCount;$index++){
                    $largeIngredients[$index]->delete();
                }
            }
        }
            return redirect()->back()->with('success', 'Sukses update bahan.');   

    }
    public function destroy(Ingredient $ingredient){
        
    }
}