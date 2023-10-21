<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Menu;
use App\Models\Ingredient;
use App\Models\Transaction;
use App\Models\Stock;
use App\Models\User;
use App\Models\Salary;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function register(){
        return view('../auth.register'); 
    }
    public function attendanceReport(){
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = Carbon::now();
        $employees = User::where('position', 'headbar')
                 ->orWhere('position', 'employee')
                 ->get();
        $totalDaysInMonth = $currentMonth->daysInMonth;

        $attendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $allAttendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $userAttendance = $attendanceData->groupBy('name');
        $allUserAttendance = $allAttendanceData->groupBy('name');
        
        return view('../layouts/contents/attendanceReport', [
            'employees' => $employees,
            'userAttendance' => $userAttendance,
            'totalDaysInMonth' => $totalDaysInMonth,
            'allUserAttendance' => $allUserAttendance,
        ]);
    }
    public function printReceipt($id){
        $salary = Salary::find($id);
        $user = User::where('position', 'owner')->first();
        $filename = $salary->name . '_' . date('F_Y', strtotime($salary->created_at)) . '_kwitansi.pdf';
        $pdf = PDF::loadView('pdf.receipt', compact('salary','user'));
        $pdf->setPaper('A6', 'landscape');
        return $pdf->download($filename);
    }

    public function salaryPayment($userName){
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        
        $currentMonth = Carbon::now();
        $totalDaysInMonth = $currentMonth->daysInMonth;
        $currentMonthName = $currentMonth->format('F');

        $presentAttendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->where('status', 1)->get();
        $userAttendanceData = $presentAttendanceData->where('name' , $userName);

        
        $ownerData = auth()->user();
        $userData = User::where('name', $userName)->first();
        return view('../layouts/contents/salaryPayment')->with([
            'currentMonth' => $currentMonthName,
            'userData' => $userData,
            'ownerData' => $ownerData, 
            'totalDaysInMonth' => $totalDaysInMonth, 
            'userAttendanceData' => $userAttendanceData
        ]);
    }

    public function stockReport(){
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
    public function addStock(){
        $ingredientNames = Ingredient::distinct()->pluck('name')->sort();
        return view('../layouts/contents/addStock') -> with(['ingredientNames' => $ingredientNames]);
    }
    public function addMenu(){
        return view('../layouts/contents/addmenu');
    }
    public function menuDetail($menu_id){
        $menus = Menu::get();
        $ingredients = Ingredient::get();
        return view('../layouts/partials/menuDetailModal')->with(['menus' => $menus, 'ingredients' => $ingredients]);
    }
}