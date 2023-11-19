<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Ingredient;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function index()
    {
        $menus = Menu::where('status',1)
            ->orderBy('name', 'asc')
            ->get();
        $sizeAvailable = Topping::select('size', 'menu_id')
            ->groupBy(['size', 'menu_id'])
            ->get();
        $tempratureAvailable =  Topping::select('name', 'menu_id')
            ->groupBy(['name', 'menu_id'])
            ->get();
        return view('../layouts/contents/dashboard')->with([
            'menus' => $menus,
            'sizeAvailable' => $sizeAvailable,
            'tempratureAvailable' => $tempratureAvailable,
        ]);
    }

    public function create(){}

    public function store(Request $request)
    {   
        $request->validate([
            'menu_id' => 'string',
            'quantity' => 'integer',
        ]);
        $ingredientsArray = [];
        $user = Auth::user();
        if(!$request->size){
            $sizeSelected = "Regular";
        }
        else {
            $sizeSelected = $request->size;
        }
        $ingredients = Ingredient::where('menu_id', $request->menu_id)
            ->where('size', $sizeSelected)
            ->get();

        $availableStock = DB::table('stocks')
            ->select('name', DB::raw('SUM(CASE WHEN kind = "pembelian" THEN quantity ELSE -quantity END) AS availableQuantity'))
            ->groupBy('name')
            ->get();
        foreach($ingredients as $index => $ingredient){
            $ingredientsArray[] = [
                'name' => ucwords($ingredient['name']),
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ];
        }
        if($request->iceLevel == 'normal_ice' || $request->iceLevel == 'less_ice' ){
            $iceQuantity = Topping::where('menu_id', $request->menu_id)
                ->where('name',$request->iceLevel)
                ->where('size', $sizeSelected)
                ->get();
                if($iceQuantity->count()>0){
                    $ingredientsArray[] = [
                        'name' => ucwords($iceQuantity[0]->ingredient_name),
                        'quantity' => $iceQuantity[0]->quantity,
                        'unit' => $iceQuantity[0]->unit,
                    ];
                }
                $selectedIceLevel = ucwords(str_replace("_", " ", $request->iceLevel));
        }
        else if ($request->iceLevel == 'no_ice'){
            $selectedIceLevel = 'No Ice';
        }
        else {
            $selectedIceLevel = 'Hot';
        }

        // Check available stock before create transaction
        $isTransactionPossible = false;
        for ($i = 0; $i < count($ingredientsArray); $i++) {
            $stockFound = false;
            for ($j = 0; $j < count($availableStock); $j++) {
                if ($availableStock[$j]->name == $ingredientsArray[$i]['name']) {
                    $stockFound = true;

                    if ($availableStock[$j]->availableQuantity < ($ingredientsArray[$i]['quantity'] * $request->quantity)) {
                        return redirect()->back()->with('error', "Stok {$ingredientsArray[$i]['name']} tidak cukup");
                    } else {
                        $isTransactionPossible = true;
                    }
                }
            }

            if (!$stockFound) {
                return redirect()->back()->with('error', "Stok kosong");
            }
        }
        if($isTransactionPossible == true){
            //Create new transction 
            $transaction = Transaction::create([  
                'menu_id' => $request->menu_id,
                'quantity' => $request->quantity,
                'user_name' => $user->name,
                'kind' => $request->kind,
                'size' => $sizeSelected,
                'temprature' => $selectedIceLevel,
            ]);
            // Get the latest transaction id after creating new one
            $newestTransaction = Transaction::latest()->first();

            // Add data to stock
            for($itemCount=1;$itemCount<=$newestTransaction->quantity;$itemCount++){
                foreach($ingredientsArray as $ingredient){
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
            return redirect()->back()->with('error', "Stok {$ingredientsArray[$i]->name} kosong");
        }
    }
    public function show(Transaction $transaction){}
    public function edit(Transaction $transaction){}
    public function update(Request $request, Transaction $transaction){}
    public function destroy(Transaction $transaction){}
}