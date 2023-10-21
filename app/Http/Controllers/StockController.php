<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockDataByKind = DB::table('stocks')
            ->select('stocks.kind', 'stocks.name', DB::raw('SUM(stocks.quantity) as total'), 'stocks.unit', 'transactions.user_name', 'transactions.created_at')
            ->join('transactions', 'stocks.transaction_id', '=', 'transactions.id')
            ->groupBy('stocks.kind', 'stocks.name', 'stocks.unit', 'transactions.user_name', 'transactions.created_at')
            ->get();

        $buyTransaction = Transaction::where('kind','pembelian')
            ->orderBy('created_at', 'desc')
            ->get();
        $boughtStocks = Stock::get();
        $overAllStockData = DB::table('stocks')
            ->select('name', 'unit', DB::raw('SUM(CASE WHEN kind = "pembelian" THEN quantity ELSE -quantity END) AS Total'))
            ->groupBy('name', 'unit')
            ->get();
        return view('../layouts/contents/stockReport') ->with([
            'overAllStockData' => $overAllStockData,
            'stockDataByKind' => $stockDataByKind,
             'buyTransaction' => $buyTransaction,
             'boughtStocks' => $boughtStocks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $ingredientNames = Ingredient::distinct()->pluck('name')->sort();
        return view('../layouts/contents/addStock') -> with(['ingredientNames' => $ingredientNames]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}