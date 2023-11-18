<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;
use App\Models\Ingredient;
use App\Models\Topping;


class MenuController extends Controller
{   
    public function index(){
        // Get all the menu data
        $menus = Menu::orderBy('name', 'asc')->get();
        // Get all the ingredients data
        $ingredients = Ingredient::get();
        return view('../layouts/contents/menuIndex')->with(['menus' => $menus, 'ingredients' => $ingredients]);
    }
    public function create(){
        return view('../layouts/contents/addmenu');
    }
    public function store(Request $request){

        // Validate request
        $request->validate([
            'name' => 'string|max:255',
            'status' => 'required|boolean',

        ]);
        $image_path = '';
        // Check if request has a image upload
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('menu', 'public');
        }
        // Insert new menu
        $menu = Menu::create([  
            'name' => ucwords($request->name),
            'status' => $request->status,
            'image' => $image_path
        ]);
        // Get the menu id form inserted menu
        $newestMenu = Menu::latest()->first();
        // Insert ingrediets data for inserted menu
        foreach($request->ingredients as $ingredient){
            $ingredients = Ingredient::create([  
                'menu_id' => $newestMenu->id,
                'name' => ucwords($ingredient['name']),
                'size' => ucwords($request->regularSize),
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
        }
        if($request->largeSize){
            foreach($request->largeIngredients as $ingredient){
                $ingredients = Ingredient::create([  
                    'menu_id' => $newestMenu->id,
                    'name' => ucwords($ingredient['name']),
                    'size' => ucwords($request->largeSize),
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ]);
            }
        }
        if($request->iced){
            if($request->largeSize){
                $toppings = Topping::create([
                    'menu_id' => $newestMenu->id,
                    'name' => 'normal_ice',
                    'ingredient_name' => 'Es',
                    'size' => 'Large',
                    'quantity' => $request->largeNormalIce,
                    'unit' => 'gram',
                ]);
                $toppings = Topping::create([
                    'menu_id' => $newestMenu->id,
                    'name' => 'less_ice',
                    'ingredient_name' => 'Es',
                    'size' => 'Large',
                    'quantity' => $request->largeLessIce,
                    'unit' => 'gram',
                ]);
            }
            if($request->regularSize) {
                $toppings = Topping::create([
                    'menu_id' => $newestMenu->id,
                    'name' => 'normal_ice',
                    'ingredient_name' => 'Es',
                    'size' => ucwords($request->regularSize),
                    'quantity' => $request->regularNormalIce,
                    'unit' => 'gram',
                ]);
                $toppings = Topping::create([
                    'menu_id' => $newestMenu->id,
                    'name' => 'less_ice',
                    'ingredient_name' => 'Es',
                    'size' => 'Regular',
                    'quantity' => $request->regularLessIce,
                    'unit' => 'gram',
                ]);
            }
        }
        if($request->hot){
            if($request->regularSize)
            $toppings = Topping::create([
                'menu_id' => $newestMenu->id,
                'name' => $request->hot,
                'ingredient_name' => 'N/A',
                'size' => 'Regular',
                'quantity' => 0,
                'unit' => 'gram',
            ]);
            if($request->largeSize) {
                $toppings = Topping::create([
                'menu_id' => $newestMenu->id,
                'name' => $request->hot,
                'ingredient_name' => 'N/A',
                'size' => 'Large',
                'quantity' => 0,
                'unit' => 'gram',
            ]);
            }
        }
       
        // Check for inserted ingredeint 
        if (!$ingredients) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan menu.');
        }
        else{
            return redirect()->back()->with('success', 'Tambah menu sukses');
        }
    }

    public function edit(Menu $menu){
        $isHotAvailable = false;
        $isIcedAvailable = false;
        // Get menu id form parameter
        $menu_id = $menu->id;
        // Get all ingredient data with menu id
        $ingredients = Ingredient::where('menu_id', $menu_id)->where('size','Regular')->get();
        $largeIngredients = Ingredient::where('menu_id',$menu_id)->where('size','Large')->get();
        $regularIceLevel = Topping::where('menu_id',$menu_id)->where('size','Regular')->get();
        $largeIceLevel = Topping::where('menu_id',$menu_id)->where('size','Large')->get();
        $toppings = Topping::where('menu_id',$menu_id)->get();
        foreach($toppings as $topping){
            if($topping->name == "normal_ice"){
                $isIcedAvailable = true;
            }
            if($topping->name == "hot"){
                $isHotAvailable = true;
            }
        }
    
        return view('../layouts/contents/editmenu')->with([
            'menu' => $menu, 
            'ingredients' => $ingredients, 
            'largeIngredients' => $largeIngredients, 
            'isHotAvailable' => $isHotAvailable,
            'isIcedAvailable' => $isIcedAvailable,
            'regularIceLevel' => $regularIceLevel,
            'largeIceLevel' => $largeIceLevel,
        ]);
    }

    public function update(Request $request, Menu $menu){
        // Validate request
        $request->validate([
            'name' => 'string|max:255',
            'status' => 'required|boolean',

        ]);
        // Update table with value of request
        $menu->name = ucwords($request->name);
        $menu->status = $request->status;
        $largeIngredients = Ingredient::where('menu_id', $menu->id)->where('size','Large')->get();
        $regularIngredients = Ingredient::where('menu_id', $menu->id)->where('size','Regular')->get();
        $hotTemprature = Topping::where('menu_id',$menu->id)->where('name','hot')->get();
        $icedTemprature = Topping::where('menu_id',$menu->id)->whereIn('name', ['less_ice', 'normal_ice'])->get();
        $sizeAvailabe = ['Regular'];
        $iceLevel = ['normal_ice' , 'less_ice'];

        // Check requiest image and update existing image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($menu->image) {
                Storage::delete($menu->image);
            }
            // Store image
            $image_path = $request->file('image')->store('menus', 'public');
            // Save to Database
            $menu->image = $image_path;
        }
        // check for large size check box
        if($request->largeSize){
            $sizeAvailabe = ['Regular', 'Large'];
            // check ingredient is ingredient is available
            if($largeIngredients->count()<1){
                // insert default ingredient form regular
                foreach($regularIngredients as $ingredient){
                    $ingredients = Ingredient::create([  
                        'menu_id' => $menu->id,
                        'name' => $ingredient->name,
                        'size' => 'Large',
                        'quantity' => $ingredient->quantity * 1.2,
                        'unit' => $ingredient->unit,
                    ]);
                };
            }
        }
        else {
            foreach($largeIngredients as $ingredient){
                $ingredient->delete();
            }
        }
        // check for hotcheckbox
        if($request->hot){
            if($hotTemprature->count() < 1){
                foreach($sizeAvailabe as $size){
                    $topping = Topping::create([
                        'menu_id' => $menu->id,
                        'name' => 'hot',
                        'ingredient_name' => 'N/A',
                        'size' => $size,
                        'quantity' => 0,
                        'unit' => 'N/A',
                    ]);
                }
            }
        }
        else {
            foreach($hotTemprature as $temprature){
                $temprature->delete();
            }
        }
        // check for ice checkbox
        if($request->iced){
            if($icedTemprature->count() < 1){
                foreach($sizeAvailabe as $index => $size){
                    $toping = Topping::create([
                        'menu_id' => $menu->id,
                        'name' => 'normal_ice',
                        'ingredient_name' => 'Es',
                        'size' => $size,
                        'quantity' => 50,
                        'unit' => 'gram',
                    ]);
                    $toping = Topping::create([
                        'menu_id' => $menu->id,
                        'name' => 'less_ice',
                        'ingredient_name' => 'Es',
                        'size' => $size,
                        'quantity' => 40,
                        'unit' => 'gram',
                    ]);
                }
            }
        }
        else {
            foreach($icedTemprature as $temprature){
                $temprature->delete();
            }
        }
        // Check updated menu
        if (!$menu->save()) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat update menu');
        }
        return redirect()->back()->with('success', 'Sukses update menu.');
    }
    public function destroy(Menu $menu){
        // Delete saved menu image
        if ($menu->image) {
            Storage::delete($menu->image);
        }
        $ingredients = Ingredient::where('menu_id', $menu->id)->get();
        foreach($ingredients as $ingredient){
            $ingredient->delete();
        }
        $toppings = Topping::where('menu_id', $menu->id)->get();
        foreach($toppings as $topping){
            $topping->delete();
        }
        // Delete menu row
        $menu->delete();
        return redirect()->back()->with('success', 'Sukses delete menu.');
    }
}