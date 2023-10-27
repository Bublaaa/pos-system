<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)
            ->orderBy('name', 'asc')
            ->get();
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
        // if ($request->hasFile('image')) {
        //     $image_path = $request->file('image')->store('products', 'public');
        // }

        $user = Auth::user();
        $ingredients = Ingredient::where('menu_id', $request->menu_id)->get();
        $availableStock = DB::table('stocks')
            ->select('name', DB::raw('SUM(CASE WHEN kind = "pembelian" THEN quantity ELSE -quantity END) AS availableQuantity'))
            ->groupBy('name')
            ->get();
        
        // Check available stock before create transaction
        $isTransactionPossible = false;

        for ($i = 0; $i < count($ingredients); $i++) {
            $stockFound = false;

            for ($j = 0; $j < count($availableStock); $j++) {
                if ($availableStock[$j]->name == $ingredients[$i]->name) {
                    $stockFound = true;

                    if ($availableStock[$j]->availableQuantity < ($ingredients[$i]->quantity * $request->quantity)) {
                        return redirect()->back()->with('error', "Stok {$ingredients[$i]->name} tidak cukup");
                    } else {
                        $isTransactionPossible = true;
                    }
                }
            }

            if (!$stockFound) {
                return redirect()->back()->with('error', "Stok {$ingredients[$i]->name} kosong");
            }
        }


        // foreach($availableStock as $stock){
        //     foreach($ingredients as $ingredient){
        //         if($stock->name == $ingredient->name){
        //             if($stock->availableQuantity < ($ingredient->quantity * $request->quantity)){
        //                 return redirect()->back()->with('error', "Stok {$ingredient['name']} tidak cukup");
        //             }
        //             else {
        //                $isTransactionPossible = true;
        //             }
        //         }
        //         else {
        //             return redirect()->back()->with('error', "Stok {$ingredient['name']} kosong");
        //         }
        //     }
        // }
        // dd($isTransactionPossible);
        if($isTransactionPossible == true){
            //Create new transction 
            $transaction = Transaction::create([  
                'menu_id' => $request->menu_id,
                'quantity' => $request->quantity,
                'user_name' => $user->name,
                'kind' => $request->kind,
                'image' => $image_path,
            ]);
            // Get the latest transaction id after creating new one
            $newestTransaction = Transaction::latest()->first();

            // Add data to stock
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
        else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencatat transaksi');
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