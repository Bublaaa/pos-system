<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {   
        $transactions = Transaction::get();
        $stocks = Stock::get();
        $menus = Menu::get();
        $buyTransaction = Transaction::where('kind','pembelian')
            ->orderBy('created_at', 'desc')
            ->get();
        $overAllStockData = DB::table('stocks')
            ->select('name', 'unit', DB::raw('SUM(CASE WHEN kind = \'pembelian\' THEN quantity ELSE -quantity END) AS Total'))
            ->groupBy('name', 'unit')
            ->get();
        $sortedStock = Stock::select('transaction_id', 'name','unit', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('transaction_id', 'name','unit')
            ->get();
        // dd($transactions);
        return view('../layouts/contents/stockReport') ->with([
            'overAllStockData' => $overAllStockData,
            'buyTransaction' => $buyTransaction,
            'menus' => $menus,
            'transactions' => $transactions,
            'stocks' => $stocks,
            'sortedStock' => $sortedStock,
        ]);
    }
    public function create()
    {
        $ingredientNames = Ingredient::distinct()->pluck('name')->sort();
        return view('../layouts/contents/addStock') -> with(['ingredientNames' => $ingredientNames]);
    }
    
    public function store(Request $request){
        $image_path = '';
        $user = Auth::user();
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('stock', 'public');
        }
        $transaction = Transaction::create([  
            'user_name' => $user->name,
            'kind' => $request->kind,
            'image' => $image_path,
        ]);
        $newestTransaction = Transaction::latest()->first();
        
        foreach($request->ingredients as $ingredient){
            $stockBought = Stock::create([  
                'transaction_id' => $newestTransaction->id,
                'kind' => $request->kind,
                'name' => $ingredient['name'],
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
        }
        if(!$transaction){
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencatat transaksi');
        }
        else {
            return redirect()->back()->with('success', 'Berhasil mencatat transaksi');
        }
    }
    public function show(Stock $stock){}
    public function edit(Stock $stock){}
    public function update(Request $request, Stock $stock){}
    public function destroy($id){
        Stock::where('transaction_id', $id)->delete();
        Transaction::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Sukses hapus transaksi.');
    }
}