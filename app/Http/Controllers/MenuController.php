<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;


class MenuController extends Controller
{   
    public function index(){
        $menus = new Menu();
        $menus = $menus->latest()->paginate(10);
        return view('../layouts/contents/dashboard')->with('menus', $menus);;
    }
    public function create(){
        $ingredients=[
            [
                'name' => 'bubuk kopi',
                'quantity' => '100',
                'unit' => 'gram',
            ]
        ];
        return view('../layouts/contents/addmenu') ->with('ingredients',$ingredients);
    }

    public function edit(){
        return view('../layouts/contents/editmenu');
    }
    
}