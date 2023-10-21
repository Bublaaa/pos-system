<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Ingredient;


class MenuController extends Controller
{   
    public function index(){
        // Get all the menu data
        $menus = Menu::get();
        // Get all the ingredients data
        $ingredients = Ingredient::get();
        return view('../layouts/contents/menuIndex')->with(['menus' => $menus, 'ingredients' => $ingredients]);
    }
    public function create(){
        
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
            'name' => $request->name,
            'status' => $request->status,
            'image' => $image_path
        ]);
        // Get the menu id form inserted menu
        $newestMenu = Menu::latest()->first();
        // Insert ingrediets data for inserted menu
        foreach($request->ingredients as $ingredient){
            $ingredients = Ingredient::create([  
                'menu_id' => $newestMenu->id,
                'name' => $ingredient['name'],
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
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
        // Get menu id form parameter
        $menu_id = $menu->id;
        // Get all ingredient data with menu id
        $ingredients = Ingredient::where('menu_id', $menu_id)->get();
        
        return view('../layouts/contents/editMenu')->with(['menu' => $menu, 'ingredients' => $ingredients]);
    }

    public function update(Request $request, Menu $menu){
        // Validate request
        $request->validate([
            'name' => 'string|max:255',
            'status' => 'required|boolean',

        ]);
        // Update table with value of request
        $menu->name = $request->name;
        $menu->status = $request->status;

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
        // Delete menu row
        $menu->delete();
        return redirect()->back()->with('success', 'Sukses delete menu.');
    }
}