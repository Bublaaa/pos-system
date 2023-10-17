<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Ingredient;


class MenuController extends Controller
{   
    public function index(){
       
    }
    public function create(){
        
    }
    public function store(Request $request){
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

    public function update(){
        
    }
    
}