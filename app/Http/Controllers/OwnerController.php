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
}