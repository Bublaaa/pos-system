<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Ingredient;


class MenuController extends Controller
{   
    public function index(){
        $menus = Menu::get();
        $ingredients = Ingredient::get();
        return view('../layouts/contents/menuIndex')->with(['menus' => $menus, 'ingredients' => $ingredients]);
    }
    public function create(){
        
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'string|max:255',
            'status' => 'required|boolean',

        ]);
        $image_path = '';
        $menu = Menu::create([  
            'name' => $request->name,
            'status' => $request->status,
            'image' => $image_path
        ]);
        $newestMenu = Menu::latest()->first();
        // dd($request->ingredients);

        foreach($request->ingredients as $ingredient){
            $ingredients = Ingredient::create([  
                'menu_id' => $newestMenu->id,
                'name' => $ingredient['name'],
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
        }
        if (!$ingredients) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan menu.');
        }
        else{
            return redirect()->back()->with('success', 'Tambah menu sukses');
        }
    }

    public function edit(Menu $menu){
        $menu_id = $menu->id;
        $ingredients = Ingredient::where('menu_id', $menu_id)->get();
        return view('../layouts/contents/editMenu')->with(['menu' => $menu, 'ingredients' => $ingredients]);
    }

    public function update(Request $request, Menu $menu){
        $request->validate([
            'name' => 'string|max:255',
            'status' => 'required|boolean',

        ]);
        $menu->name = $request->name;
        $menu->status = $request->status;

        // if ($request->hasFile('image')) {
        //     // Delete old image
        //     if ($product->image) {
        //         Storage::delete($product->image);
        //     }
        //     // Store image
        //     $image_path = $request->file('image')->store('products', 'public');
        //     // Save to Database
        //     $product->image = $image_path;
        // }

        if (!$menu->save()) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat update menu');
        }
        return redirect()->back()->with('success', 'Sukses update menu.');
    }
    public function destroy(Menu $menu){
        // if ($menu->image) {
        //     Storage::delete($menu->image);
        // }
        $menu->delete();
        return redirect()->back()->with('success', 'Sukses delete menu.');
    }
}