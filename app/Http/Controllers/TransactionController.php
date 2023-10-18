<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Menu;
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
            'menu_id' => 'required|string',
            'quantity' => 'required|integer',
        ]);
        $user = Auth::user();
        for($itemCount=1;$itemCount<=$request->quantity;$itemCount++){
            $transaction = Transaction::create([  
                'menu_id' => $request->menu_id,
                'user_name' => $user->name,
            ]);
        }
        if(!$transaction){
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan transaksi');
        }
        else {
            return redirect()->back()->with('success', 'Berhasil menambahkan transaksi');
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