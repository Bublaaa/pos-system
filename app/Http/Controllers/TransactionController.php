<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        return view('../layouts/contents/dashboard')->with('menus', $menus);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'string',
            'quantity' => 'integer',
        ]);
        $image_path = '';
        $user = Auth::user();
        $ingredients = Ingredient::where('menu_id', $request->menu_id)->get();
        // if ($request->hasFile('image')) {
        //     $image_path = $request->file('image')->store('products', 'public');
        // }
        $transaction = Transaction::create([  
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'user_name' => $user->name,
            'kind' => $request->kind,
            'image' => $image_path,
        ]);
        $newestTransaction = Transaction::latest()->first();

        for($itemCount=1;$itemCount<=$newestTransaction->quantity;$itemCount++){
            foreach($ingredients as $ingredient){
                $stockSold = Stock::create([  
                    'transaction_id' => $newestTransaction->id,
                    'kind' => $request->kind,
                    'name' => $ingredient['name'],
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ]);
            }
        }
        if(!$transaction){
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencatat transaksi');
        }
        else {
            return redirect()->back()->with('success', 'Berhasil mencatat transaksi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}