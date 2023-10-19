<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Menu;
use App\Models\Ingredient;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function register(){
        return view('../auth.register'); 
    }
    public function attendanceReport(){
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = Carbon::now();
        $totalDaysInMonth = $currentMonth->daysInMonth;

        $attendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->where('status', 1)->get();
        $allAttendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();
        
        $userAttendance = $attendanceData->groupBy('name');
        $allUserAttendance = $allAttendanceData->groupBy('name');
        
        return view('../layouts/contents/attendanceReport', [
            'userAttendance' => $userAttendance,
            'totalDaysInMonth' => $totalDaysInMonth,
            'allUserAttendance' => $allUserAttendance,
        ]);
    }
    public function salaryReport(){
        return view('../layouts/contents/salaryReport');
    }
    public function stockReport(){
        $stockDataByKind = DB::table('stocks')
            ->select('kind', 'name', DB::raw('SUM(quantity) as total'), 'unit')
            ->groupBy('kind', 'name', 'unit')
            ->get();
        $overAllStockData = DB::table('stocks')
            ->select('name', 'unit', DB::raw('SUM(CASE WHEN kind = "pembelian" THEN quantity ELSE -quantity END) AS Total'))
            ->groupBy('name', 'unit')
            ->get();
        return view('../layouts/contents/stockReport') ->with(['overAllStockData' => $overAllStockData,'stockDataByKind' => $stockDataByKind]);
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